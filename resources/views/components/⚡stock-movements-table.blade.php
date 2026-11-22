<?php

use App\Models\StockMovement;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $search = '';

    public string $type = 'all';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedType(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function movements()
    {
        $term = trim($this->search);

        return StockMovement::with(['product', 'order', 'user'])
            ->when($this->type !== 'all', fn ($query) => $query->where('type', $this->type))
            ->when($term !== '', fn ($query) => $query->whereHas('product', fn ($p) => $p->search($term)))
            ->latest()
            ->latest('id')
            ->paginate(15);
    }
};
?>

<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row">
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="Buscar por produto (nome ou SKU)..."
            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
        >

        <select
            wire:model.live="type"
            class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:w-56"
        >
            <option value="all">Todas as movimentações</option>
            @foreach (\App\Enums\StockMovementType::cases() as $case)
                <option value="{{ $case->value }}">{{ $case->label() }}</option>
            @endforeach
        </select>
    </div>

    <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-3">Data</th>
                    <th class="px-4 py-3">Produto</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3 text-right">Quantidade</th>
                    <th class="px-4 py-3">Motivo</th>
                    <th class="px-4 py-3">Pedido</th>
                    <th class="px-4 py-3">Usuário</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($this->movements as $movement)
                    <tr wire:key="movement-{{ $movement->id }}">
                        <td class="px-4 py-3">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">
                            <span class="font-medium">{{ $movement->product->name }}</span>
                            <span class="block text-xs text-gray-500">{{ $movement->product->sku }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $movement->type->badgeClasses() }}">
                                {{ $movement->type->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right font-medium">{{ $movement->type->sign() }}{{ $movement->quantity }}</td>
                        <td class="px-4 py-3">{{ $movement->reason ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @if ($movement->order_id)
                                <a href="{{ route('orders.show', $movement->order_id) }}" class="text-indigo-600 hover:underline">#{{ $movement->order_id }}</a>
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $movement->user?->name ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">Nenhuma movimentação encontrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $this->movements->links() }}
    </div>
</div>
