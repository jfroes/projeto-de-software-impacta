<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ReportService
{
    /** Pedidos que contam como venda: já faturados e não cancelados. */
    private function salesStatuses(): array
    {
        return [
            OrderStatus::FATURADO->value,
            OrderStatus::SAIU_ENTREGA->value,
            OrderStatus::ENTREGUE->value,
        ];
    }

    private function salesQuery(Carbon $start, Carbon $end): Builder
    {
        return Order::query()
            ->whereIn('status', $this->salesStatuses())
            ->whereBetween('billed_at', [$start, $end]);
    }

    /** Resumo do período: quantidade de vendas, faturamento e ticket médio. */
    public function summary(Carbon $start, Carbon $end): array
    {
        $row = $this->salesQuery($start, $end)
            ->selectRaw('COUNT(*) as orders_count, COALESCE(SUM(total), 0) as revenue')
            ->first();

        $count = (int) $row->orders_count;
        $revenue = (float) $row->revenue;

        return [
            'orders_count' => $count,
            'revenue' => $revenue,
            'average_ticket' => $count > 0 ? round($revenue / $count, 2) : 0.0,
        ];
    }

    /** Vendas agrupadas por dia de faturamento. */
    public function salesByDay(Carbon $start, Carbon $end): Collection
    {
        return $this->salesQuery($start, $end)
            ->selectRaw('DATE(billed_at) as day, COUNT(*) as orders_count, SUM(total) as revenue')
            ->groupBy('day')
            ->orderBy('day')
            ->get();
    }

    /** Produtos mais vendidos no período (por quantidade). */
    public function topProducts(Carbon $start, Carbon $end, int $limit = 10): Collection
    {
        return OrderItem::query()
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereIn('orders.status', $this->salesStatuses())
            ->whereBetween('orders.billed_at', [$start, $end])
            ->selectRaw('order_items.product_id, MAX(order_items.product_name) as product_name, SUM(order_items.quantity) as total_quantity, SUM(order_items.subtotal) as total_revenue')
            ->groupBy('order_items.product_id')
            ->orderByDesc('total_quantity')
            ->limit($limit)
            ->get();
    }

    /** Pedidos criados no período, agrupados por status (todos os status aparecem, mesmo com zero). */
    public function ordersByStatus(Carbon $start, Carbon $end): Collection
    {
        $rows = Order::query()
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('status, COUNT(*) as orders_count, COALESCE(SUM(total), 0) as amount')
            ->groupBy('status')
            ->get()
            ->keyBy(fn ($row) => $row->status->value);

        return collect(OrderStatus::cases())->map(fn (OrderStatus $case) => [
            'status' => $case,
            'orders_count' => (int) ($rows->get($case->value)?->orders_count ?? 0),
            'amount' => (float) ($rows->get($case->value)?->amount ?? 0),
        ]);
    }
}
