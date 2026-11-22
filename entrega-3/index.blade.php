<x-app-layout>
    <div class="mx-auto max-w-7xl p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Pedidos</h1>
            <a href="{{ route('orders.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Novo pedido
            </a>
        </div>

        <livewire:orders-table />
    </div>
</x-app-layout>
