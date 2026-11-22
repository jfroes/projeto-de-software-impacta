<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(private ReportService $reports) {}

    public function index(Request $request): View
    {
        return view('reports.index', $this->data($request));
    }

    public function pdf(Request $request)
    {
        $data = $this->data($request);

        return Pdf::loadView('pdf.report', $data)
            ->download('relatorio-vendas-'.now()->format('Ymd').'.pdf');
    }

    /** Valida o período (padrão: do início do mês até hoje) e monta os dados dos relatórios. */
    private function data(Request $request): array
    {
        $request->merge([
            'start' => $request->input('start') ?: now()->startOfMonth()->toDateString(),
            'end' => $request->input('end') ?: now()->toDateString(),
        ]);

        $validated = $request->validate([
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after_or_equal:start'],
        ], [
            'start.date' => 'Data inicial inválida.',
            'end.date' => 'Data final inválida.',
            'end.after_or_equal' => 'A data final deve ser igual ou posterior à data inicial.',
        ]);

        $start = Carbon::parse($validated['start'])->startOfDay();
        $end = Carbon::parse($validated['end'])->endOfDay();

        return [
            'start' => $start,
            'end' => $end,
            'summary' => $this->reports->summary($start, $end),
            'salesByDay' => $this->reports->salesByDay($start, $end),
            'topProducts' => $this->reports->topProducts($start, $end),
            'ordersByStatus' => $this->reports->ordersByStatus($start, $end),
        ];
    }
}
