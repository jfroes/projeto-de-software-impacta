<x-layouts.main-layout title="Produto" class="bg-[#f8f9ff] text-[#1a1b20]">
    <div class="space-y-6">
        <header>
            <a href="{{ route('products.index') }}" class="mb-4 inline-flex items-center gap-2 text-sm font-bold text-[#006a6a] hover:underline">
                <span class="material-symbols-outlined">arrow_back</span>
                Produtos
            </a>
            <h2 class="text-3xl font-bold tracking-tight text-[#1a1b20]">{{ $product->name }}</h2>
            <p class="mt-2 text-sm text-[#73777f]">Detalhes completos do produto.</p>
        </header>

        <section class="rounded-3xl border border-[#e1e2e9] bg-white p-6 shadow-[0_4px_16px_rgba(25,28,30,0.05)] md:p-8">
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <p class="text-sm text-[#73777f]">Nome</p>
                    <p class="mt-1 text-base font-bold text-[#1a1b20]">{{ $product->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">SKU</p>
                    <p class="mt-1 text-base font-bold text-[#1a1b20]">{{ $product->sku }}</p>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">Preço</p>
                    <p class="mt-1 text-base font-bold text-[#1a1b20]">R$ {{ number_format((float) $product->price, 2, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">Estoque</p>
                    <div class="mt-1 flex flex-wrap items-center gap-2">
                        <p class="text-base font-bold text-[#1a1b20]">{{ $product->stock_quantity }}</p>
                        @if ($product->isLowStock())
                            <span class="inline-flex rounded-full bg-[#fff7d6] px-2.5 py-1 text-xs font-bold text-[#7a5900]">Estoque baixo</span>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">Status</p>
                    <span class="mt-1 inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $product->active ? 'bg-[#e6f7f5] text-[#005454]' : 'bg-[#eef0f4] text-[#5f636b]' }}">
                        {{ $product->active ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">Descrição</p>
                    <p class="mt-1 text-base text-[#1a1b20]">{{ $product->description ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">Criado em</p>
                    <p class="mt-1 text-base text-[#1a1b20]">{{ optional($product->created_at)->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">Atualizado em</p>
                    <p class="mt-1 text-base text-[#1a1b20]">{{ optional($product->updated_at)->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </section>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#005454]">
                <span class="material-symbols-outlined">arrow_back</span>
                Voltar
            </a>

            @if (auth()->user()->role->canManageCatalog())
                <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#006a6a] px-5 py-3 text-sm font-bold text-[#006a6a] transition hover:bg-[#e6f7f5]">
                    <span class="material-symbols-outlined">edit</span>
                    Editar
                </a>
            @endif
        </div>
    </div>
</x-layouts.main-layout>
