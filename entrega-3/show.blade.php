<x-app-layout>
    <div class="mx-auto max-w-4xl space-y-6 p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-semibold">Pedido #{{ $order->id }}</h1>
                <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $order->status->badgeClasses() }}">
                    {{ $order->status->label() }}
                </span>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('orders.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Voltar</a>

                @if ($order->status->canGeneratePdf())
                    <a href="{{ route('orders.pdf', $order) }}" class="rounded-lg border border-indigo-600 px-4 py-2 text-sm font-medium text-indigo-600 hover:bg-indigo-50">
                        Baixar PDF (NF)
                    </a>
                @endif

                @if ($order->status->canCancel())
                    <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Cancelar este pedido? O estoque será devolvido.')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="rounded-lg border border-red-600 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50">Cancelar pedido</button>
                    </form>
                @endif

                @if ($order->status->advanceLabel())
                    <form method="POST" action="{{ route('orders.advance', $order) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                            {{ $order->status->advanceLabel() }}
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid gap-4 rounded-xl border border-gray-200 bg-white p-6 text-sm sm:grid-cols-2">
            <div>
                <p class="text-gray-500">Cliente</p>
                <p class="font-medium">{{ $order->client->name }}</p>
                <p class="text-gray-600">{{ $order->client->document_formatted }}</p>
            </div>
            <div>
                <p class="text-gray-500">Vendedor</p>
                <p class="font-medium">{{ $order->user->name }}</p>
            </div>
            <div>
                <p class="text-gray-500">Criado em</p>
                <p class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-500">Faturado em</p>
                <p class="font-medium">{{ $order->billed_at ? $order->billed_at->format('d/m/Y H:i') : '—' }}</p>
            </div>
            @if ($order->notes)
                <div class="sm:col-span-2">
                    <p class="text-gray-500">Observações</p>
                    <p class="font-medium">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Produto</th>
                        <th class="px-4 py-3 text-right">Preço unit.</th>
                        <th class="px-4 py-3 text-right">Qtd.</th>
                        <th class="px-4 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="px-4 py-3">{{ $item->product_name }}</td>
                            <td class="px-4 py-3 text-right">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-right">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right font-medium">Total</td>
                        <td class="px-4 py-3 text-right text-base font-semibold">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-app-layout>
