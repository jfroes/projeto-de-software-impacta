<x-layouts.main-layout title="Clientes" class="bg-[#f8f9ff] text-[#1a1b20]">
    <div class="space-y-6">
        <header class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-medium text-[#006a6a]">Cadastro</p>
                <h2 class="mt-1 text-3xl font-bold tracking-tight text-[#1a1b20]">Clientes</h2>
                <p class="mt-2 text-sm text-[#73777f]">Gerencie os clientes cadastrados no sistema.</p>
            </div>

            <a href="{{ route('clients.create') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#005454]">
                <span class="material-symbols-outlined">add</span>
                Novo cliente
            </a>
        </header>

        <livewire:clients-table />
    </div>
</x-layouts.main-layout>
