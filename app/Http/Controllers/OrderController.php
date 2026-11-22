<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    /** A listagem e o filtro ficam no componente Livewire <livewire:orders-table />. */
    public function index(): View
    {
        return view('orders.index');
    }

    /** O formulário (cliente + itens) é o componente Livewire <livewire:order-form />. */
    public function create(): View
    {
        return view('orders.create');
    }

    public function show(Order $order): View
    {
        $order->load(['client', 'user', 'items']);

        return view('orders.show', compact('order'));
    }

    /** Faturar / saiu para entrega / entregue: sempre o próximo status do fluxo. */
    public function advance(Order $order, OrderService $service): RedirectResponse
    {
        try {
            $order = $service->advance($order);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', "Pedido #{$order->id} atualizado para: {$order->status->label()}.");
    }

    public function cancel(Order $order, OrderService $service): RedirectResponse
    {
        try {
            $order = $service->cancel($order);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', "Pedido #{$order->id} cancelado e estoque devolvido.");
    }

    /** NF simulada em PDF: só depois do faturamento. */
    public function pdf(Order $order)
    {
        if (! $order->status->canGeneratePdf()) {
            return back()->with('error', 'O PDF só fica disponível após o faturamento do pedido.');
        }

        $order->load(['client', 'user', 'items']);

        return Pdf::loadView('pdf.order', compact('order'))
            ->download("pedido-{$order->id}.pdf");
    }
}
