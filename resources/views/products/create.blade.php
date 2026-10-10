<x-layouts.main-layout title="Novo produto" class="bg-[#f8f9ff] text-[#1a1b20]">
    <div class="space-y-6">
        <header>
            <a href="{{ route('products.index') }}" class="mb-4 inline-flex items-center gap-2 text-sm font-bold text-[#006a6a] hover:underline">
                <span class="material-symbols-outlined">arrow_back</span>
                Produtos
            </a>
            <h2 class="text-3xl font-bold tracking-tight text-[#1a1b20]">Novo produto</h2>
            <p class="mt-2 text-sm text-[#73777f]">Preencha os dados para cadastrar um novo produto.</p>
        </header>

        @include('products._form')
    </div>
</x-layouts.main-layout>
