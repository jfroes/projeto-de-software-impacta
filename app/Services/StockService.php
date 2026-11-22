<?php

namespace App\Services;

use App\Enums\StockMovementType;
use App\Models\Product;
use App\Models\StockMovement;
use DomainException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Apenas REGISTRA a movimentação no histórico (não altera o estoque do produto).
     * Quem muda o stock_quantity chama este método logo em seguida, na mesma transação.
     */
    public function register(
        int $productId,
        StockMovementType $type,
        int $quantity,
        ?string $reason = null,
        ?int $orderId = null,
        ?int $userId = null,
    ): StockMovement {
        return StockMovement::create([
            'product_id' => $productId,
            'type' => $type,
            'quantity' => $quantity,
            'reason' => $reason,
            'order_id' => $orderId,
            'user_id' => $userId ?? Auth::id(),
        ]);
    }

    /**
     * Movimentação manual (reposição, ajuste, perda): altera o estoque E registra o histórico,
     * em uma única transação.
     *
     * @throws DomainException
     */
    public function adjust(int $productId, StockMovementType $type, int $quantity, string $reason): StockMovement
    {
        return DB::transaction(function () use ($productId, $type, $quantity, $reason) {
            $product = Product::lockForUpdate()->findOrFail($productId);

            if ($type === StockMovementType::SAIDA) {
                if ($product->stock_quantity < $quantity) {
                    throw new DomainException(
                        "Estoque insuficiente para \"{$product->name}\": disponível {$product->stock_quantity}, saída solicitada {$quantity}."
                    );
                }

                $product->decrement('stock_quantity', $quantity);
            } else {
                $product->increment('stock_quantity', $quantity);
            }

            return $this->register($product->id, $type, $quantity, $reason);
        });
    }
}
