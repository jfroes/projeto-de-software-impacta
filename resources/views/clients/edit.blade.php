<x-layouts.main-layout title="Editar cliente" class="bg-[#f8f9ff] text-[#1a1b20]">
    <div class="space-y-6">
        <header>
            <a href="{{ route('clients.index') }}" class="mb-4 inline-flex items-center gap-2 text-sm font-bold text-[#006a6a] hover:underline">
                <span class="material-symbols-outlined">arrow_back</span>
                Clientes
            </a>
            <h2 class="text-3xl font-bold tracking-tight text-[#1a1b20]">Editar cliente</h2>
            <p class="mt-2 text-sm text-[#73777f]">Atualize os dados do cliente selecionado.</p>
        </header>

        @include('clients._form', ['client' => $client])
    </div>
</x-layouts.main-layout>
