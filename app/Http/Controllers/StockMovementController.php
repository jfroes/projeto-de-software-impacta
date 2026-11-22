<?php

namespace App\Http\Controllers;

use App\Enums\StockMovementType;
use App\Models\Product;
use App\Services\StockService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    /** Motivos disponíveis na movimentação manual. */
    private const REASONS = [
        'Compra / reposição',
        'Ajuste de inventário',
        'Perda / avaria',
        'Devolução de cliente',
    ];

    /** O histórico e os filtros ficam no componente Livewire <livewire:stock-movements-table />. */
    public function index(): View
    {
        return view('stock-movements.index');
    }

    public function create(): View
    {
        return view('stock-movements.create', [
            'products' => Product::orderBy('name')->get(),
            'reasons' => self::REASONS,
        ]);
    }

    public function store(Request $request, StockService $stock): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', Rule::enum(StockMovementType::class)],
            'quantity' => ['required', 'integer', 'min:1'],
            'reason' => ['required', Rule::in(self::REASONS)],
        ], [
            'product_id.required' => 'Selecione o produto.',
            'product_id.exists' => 'Produto inválido.',
            'type.required' => 'Selecione o tipo de movimentação.',
            'quantity.required' => 'Informe a quantidade.',
            'quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'quantity.min' => 'A quantidade mínima é 1.',
            'reason.required' => 'Selecione o motivo.',
            'reason.in' => 'Motivo inválido.',
        ]);

        try {
            $stock->adjust(
                (int) $data['product_id'],
                StockMovementType::from($data['type']),
                (int) $data['quantity'],
                $data['reason'],
            );
        } catch (DomainException $e) {
            return back()->withInput()->withErrors(['quantity' => $e->getMessage()]);
        }

        return redirect()
            ->route('stock-movements.index')
            ->with('success', 'Movimentação registrada com sucesso.');
    }
}
