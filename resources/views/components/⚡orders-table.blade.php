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

<div class="space-y-6">
    <section class="overflow-hidden rounded-3xl border border-[#e1e2e9] bg-white shadow-[0_2px_4px_rgba(25,28,30,0.05)]">
        <div class="border-b border-[#e1e2e9] p-5 md:p-6">
            <div class="flex flex-col gap-3 md:flex-row">
                <label for="orders-search" class="sr-only">Pesquisar pedidos</label>
                <input
                    id="orders-search"
                    type="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por nº do pedido ou cliente..."
                    class="min-w-0 flex-1 rounded-xl border border-[#74777f] px-4 py-3 text-sm outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]"
                >

                <select
                    wire:model.live="status"
                    aria-label="Filtrar por status"
                    class="rounded-xl border border-[#74777f] bg-white px-4 py-3 text-sm outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]"
                >
                    <option value="all">Todos os status</option>
                    @foreach (\App\Enums\OrderStatus::cases() as $case)
                        <option value="{{ $case->value }}">{{ $case->label() }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#e1e2e9]">
                <thead class="bg-[#f8f9ff]">
                    <tr>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Pedido</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Cliente</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Vendedor</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Status</th>
                        <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wide text-[#73777f]">Total</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Data</th>
                        <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wide text-[#73777f]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eef0f4] bg-white">
                    @forelse ($this->orders as $order)
                        <tr wire:key="order-{{ $order->id }}" class="hover:bg-[#fbfcff]">
                            <td class="px-5 py-4 text-sm font-bold text-[#1a1b20]">#{{ $order->id }}</td>
                            <td class="px-5 py-4 text-sm text-[#44474f]">{{ $order->client->name }}</td>
                            <td class="px-5 py-4 text-sm text-[#44474f]">{{ $order->user->name }}</td>
                            <td class="px-5 py-4 text-sm">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $order->status->badgeClasses() }}">
                                    {{ $order->status->label() }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right text-sm text-[#44474f]">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                            <td class="px-5 py-4 text-sm text-[#44474f]">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-4 text-right text-sm">
                                <a href="{{ route('orders.show', $order) }}" class="font-bold text-[#006a6a] hover:underline">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-sm text-[#73777f]">Nenhum pedido encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-[#e1e2e9] px-5 py-4">
            {{ $this->orders->links() }}
        </div>
    </section>
</div>
