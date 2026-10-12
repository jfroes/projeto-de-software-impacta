<?php

use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
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
    public function products()
    {
        return Product::query()
            ->search($this->search)
            ->when($this->status === 'active', fn ($query) => $query->active())
            ->when($this->status === 'inactive', fn ($query) => $query->where('active', false))
            ->orderBy('name')
            ->paginate(10);
    }
};
?>

<div class="space-y-6">


    <section class="overflow-hidden rounded-3xl border border-[#e1e2e9] bg-white shadow-[0_2px_4px_rgba(25,28,30,0.05)]">
        <div class="border-b border-[#e1e2e9] p-5 md:p-6">
            <div class="flex flex-col gap-3 md:flex-row">
                <label for="search" class="sr-only">Pesquisar produtos</label>
                <input
                    id="search"
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por nome ou SKU"
                    class="min-w-0 flex-1 rounded-xl border border-[#74777f] px-4 py-3 text-sm outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]"
                />

                <select
                    wire:model.live="status"
                    aria-label="Filtrar por status"
                    class="rounded-xl border border-[#74777f] bg-white px-4 py-3 text-sm outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]"
                >
                    <option value="all">Todos os status</option>
                    <option value="active">Ativos</option>
                    <option value="inactive">Inativos</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#e1e2e9]">
                <thead class="bg-[#f8f9ff]">
                    <tr>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Nome</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">SKU</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Preço</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Estoque</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Status</th>
                        <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wide text-[#73777f]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eef0f4] bg-white">
                    @forelse ($this->products as $product)
                        <tr wire:key="product-{{ $product->id }}" class="hover:bg-[#fbfcff]">
                            <td class="px-5 py-4 text-sm font-bold text-[#1a1b20]">
                                {{ $product->name }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-[#44474f]">
                                {{ $product->sku }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-[#44474f]">
                                R$ {{ number_format((float) $product->price, 2, ',', '.') }}
                            </td>
                            <td class="px-5 py-4 text-sm text-[#44474f]">
                                <div class="flex flex-col gap-1">
                                    <span>{{ $product->stock_quantity }}</span>
                                    @if ($product->isLowStock())
                                        <span class="inline-flex w-fit rounded-full bg-[#fff7d6] px-2.5 py-1 text-xs font-bold text-[#7a5900]">
                                            Estoque baixo
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $product->active ? 'bg-[#e6f7f5] text-[#005454]' : 'bg-[#eef0f4] text-[#5f636b]' }}">
                                    {{ $product->active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('products.show', $product) }}" class="font-bold text-[#006a6a] hover:underline">
                                        Ver
                                    </a>

                                    @if (auth()->user()->role->canManageCatalog())
                                        <a href="{{ route('products.edit', $product) }}" class="font-bold text-[#006a6a] hover:underline">
                                            Editar
                                        </a>

                                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Deseja excluir este produto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="cursor-pointer font-bold text-[#ba1a1a] hover:underline">
                                                Excluir
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-sm text-[#73777f]">
                                Nenhum produto encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-[#e1e2e9] px-5 py-4">
            {{ $this->products->links() }}
        </div>
    </section>
</div>
