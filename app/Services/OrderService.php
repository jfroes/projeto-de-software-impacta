<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\StockMovementType;
use App\Models\Order;
use App\Models\Product;
use DomainException;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(private StockService $stock) {}

    /**
     * Cria o pedido com baixa de estoque, tudo em uma única transação.
     * Qualquer falha (ex.: estoque insuficiente) desfaz o pedido inteiro.
     *
     * @param  array<int, array{product_id: int|string, quantity: int|string}>  $items
     *
     * @throws DomainException
     */
    public function createOrder(int $clientId, int $userId, array $items, ?string $notes = null): Order
    {
        return DB::transaction(function () use ($clientId, $userId, $items, $notes) {
            // Junta linhas repetidas do mesmo produto e ordena por id (evita deadlock).
            $quantities = collect($items)
                ->groupBy('product_id')
                ->map(fn ($rows) => (int) $rows->sum('quantity'))
                ->sortKeys();

            if ($quantities->isEmpty()) {
                throw new DomainException('Adicione ao menos um item ao pedido.');
            }

            // Trava as linhas dos produtos até o fim da transação.
            $products = Product::whereIn('id', $quantities->keys()->all())
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $order = Order::create([
                'client_id' => $clientId,
                'user_id' => $userId,
                'status' => OrderStatus::ABERTO,
                'total' => 0,
                'notes' => $notes,
            ]);

            $total = 0.0;

            foreach ($quantities as $productId => $quantity) {
                $product = $products->get($productId);

                if (! $product || ! $product->active) {
                    throw new DomainException('Um dos produtos selecionados não está disponível.');
                }

                if ($product->stock_quantity < $quantity) {
                    throw new DomainException(
                        "Estoque insuficiente para \"{$product->name}\": disponível {$product->stock_quantity}, solicitado {$quantity}."
                    );
                }

                $product->decrement('stock_quantity', $quantity);

                $subtotal = round((float) $product->price * $quantity, 2);

                // Snapshot: nome e preço do momento da venda.
                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);

                // Histórico: saída por venda.
                $this->stock->register(
                    $product->id,
                    StockMovementType::SAIDA,
                    $quantity,
                    'Venda',
                    $order->id,
                    $userId,
                );

                $total += $subtotal;
            }

            $order->update(['total' => round($total, 2)]);

            return $order;
        });
    }

    /**
     * Avança o pedido para o próximo status do fluxo:
     * aberto -> faturado -> saiu para entrega -> entregue.
     *
     * @throws DomainException
     */
    public function advance(Order $order): Order
    {
        return DB::transaction(function () use ($order) {
            $order = Order::lockForUpdate()->findOrFail($order->id);

            $next = $order->status->next();

            if ($next === null) {
                throw new DomainException('Este pedido não pode mais avançar de status.');
            }

            $data = ['status' => $next];

            if ($next === OrderStatus::FATURADO) {
                $data['billed_at'] = now();
            }

            $order->update($data);

            return $order;
        });
    }

    /**
     * Cancela o pedido e devolve a quantidade de cada item ao estoque,
     * registrando a entrada no histórico de movimentações.
     *
     * @throws DomainException
     */
    public function cancel(Order $order): Order
    {
        return DB::transaction(function () use ($order) {
            $order = Order::with('items')->lockForUpdate()->findOrFail($order->id);

            if (! $order->status->canCancel()) {
                throw new DomainException('Este pedido não pode mais ser cancelado.');
            }

            foreach ($order->items as $item) {
                Product::whereKey($item->product_id)->increment('stock_quantity', $item->quantity);

                $this->stock->register(
                    $item->product_id,
                    StockMovementType::ENTRADA,
                    $item->quantity,
                    'Cancelamento do pedido',
                    $order->id,
                );
            }

            $order->update(['status' => OrderStatus::CANCELADO]);

            return $order;
        });
    }
}
