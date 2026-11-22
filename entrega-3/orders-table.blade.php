<?php

use App\Models\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = 'all';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function orders()
    {
        $term = trim($this->search);

        return Order::with(['client', 'user'])
            ->when($this->status !== 'all', fn ($query) => $query->where('status', $this->status))
            ->when($term !== '', function ($query) use ($term) {
                $query->where(function ($q) use ($term) {
                    $number = ltrim($term, '#');

                    if (is_numeric($number)) {
                        $q->orWhere('id', (int) $number);
                    }

                    $q->orWhereHas('client', fn ($c) => $c->search($term));
                });
            })
            ->latest()
            ->paginate(10);
    }
};
?>

<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row">
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="Buscar por nº do pedido ou cliente..."
            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
        >

        <select
            wire:model.live="status"
            class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:w-56"
        >
            <option value="all">Todos os status</option>
            @foreach (\App\Enums\OrderStatus::cases() as $case)
                <option value="{{ $case->value }}">{{ $case->label() }}</option>
            @endforeach
        </select>
    </div>

    <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-3">Pedido</th>
                    <th class="px-4 py-3">Cliente</th>
                    <th class="px-4 py-3">Vendedor</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Total</th>
                    <th class="px-4 py-3">Data</th>
                    <th class="px-4 py-3 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($this->orders as $order)
                    <tr wire:key="order-{{ $order->id }}">
                        <td class="px-4 py-3 font-medium">#{{ $order->id }}</td>
                        <td class="px-4 py-3">{{ $order->client->name }}</td>
                        <td class="px-4 py-3">{{ $order->user->name }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $order->status->badgeClasses() }}">
                                {{ $order->status->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:underline">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">Nenhum pedido encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $this->orders->links() }}
    </div>
</div>
