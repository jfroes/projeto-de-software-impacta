<x-layouts.main-layout title="Novo cliente" class="bg-[#f8f9ff] text-[#1a1b20]">
    <div class="space-y-6">
        <header>
            <a href="{{ route('clients.index') }}" class="mb-4 inline-flex items-center gap-2 text-sm font-bold text-[#006a6a] hover:underline">
                <span class="material-symbols-outlined">arrow_back</span>
                Clientes
            </a>
            <h2 class="text-3xl font-bold tracking-tight text-[#1a1b20]">Novo cliente</h2>
            <p class="mt-2 text-sm text-[#73777f]">Preencha os dados para cadastrar um novo cliente.</p>
        </header>

        @include('clients._form')
    </div>
</x-layouts.main-layout>
