<x-layouts.main-layout title="Movimentações de estoque" class="bg-[#f8f9ff] text-[#1a1b20]">
    <div class="mx-auto max-w-7xl p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Movimentações de estoque</h1>
            <a href="{{ route('stock-movements.create') }}" class="rounded-lg bg-[#006a6a] px-4 py-2 text-sm font-medium text-white hover:bg-[#005454]">
                Nova movimentação
            </a>
        </div>

        <livewire:stock-movements-table />
    </div>
</x-layouts.main-layout>
