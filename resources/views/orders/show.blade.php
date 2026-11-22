<x-layouts.main-layout title="Pedido #{{ $order->id }}" class="bg-[#f8f9ff] text-[#1a1b20]">
    <div class="space-y-6">
        <header class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#006a6a] hover:underline">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Pedidos
                </a>
                <h2 class="text-3xl font-bold tracking-tight text-[#1a1b20]">Pedido #{{ $order->id }}</h2>
                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $order->status->badgeClasses() }}">
                    {{ $order->status->label() }}
                </span>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                @if ($order->status->canGeneratePdf())
                    <a href="{{ route('orders.pdf', $order) }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#006a6a] px-5 py-3 text-sm font-bold text-[#006a6a] transition hover:bg-[#e6f7f5]">
                        <span class="material-symbols-outlined">download</span>
                        Baixar PDF
                    </a>
                @endif

                @if ($order->status->canCancel())
                    <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Cancelar este pedido? O estoque será devolvido.')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#ba1a1a] px-5 py-3 text-sm font-bold text-[#ba1a1a] transition hover:bg-[#fff0f0]">
                            <span class="material-symbols-outlined">cancel</span>
                            Cancelar
                        </button>
                    </form>
                @endif

                @if ($order->status->advanceLabel())
                    <form method="POST" action="{{ route('orders.advance', $order) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#005454]">
                            <span class="material-symbols-outlined">check_circle</span>
                            {{ $order->status->advanceLabel() }}
                        </button>
                    </form>
                @endif
            </div>
        </header>

        <section class="rounded-3xl border border-[#e1e2e9] bg-white p-6 shadow-[0_4px_16px_rgba(25,28,30,0.05)] md:p-8">
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <p class="text-sm text-[#73777f]">Cliente</p>
                    <p class="mt-1 text-base font-bold text-[#1a1b20]">{{ $order->client->name }}</p>
                    <p class="text-sm text-[#44474f]">{{ $order->client->document_formatted }}</p>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">Vendedor</p>
                    <p class="mt-1 text-base font-bold text-[#1a1b20]">{{ $order->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">Criado em</p>
                    <p class="mt-1 text-base font-bold text-[#1a1b20]">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">Faturado em</p>
                    <p class="mt-1 text-base font-bold text-[#1a1b20]">{{ $order->billed_at ? $order->billed_at->format('d/m/Y H:i') : '—' }}</p>
                </div>
                @if ($order->notes)
                    <div class="md:col-span-2">
                        <p class="text-sm text-[#73777f]">Observações</p>
                        <p class="mt-1 text-base text-[#1a1b20]">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="overflow-hidden rounded-3xl border border-[#e1e2e9] bg-white shadow-[0_2px_4px_rgba(25,28,30,0.05)]">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#e1e2e9]">
                    <thead class="bg-[#f8f9ff]">
                        <tr>
                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Produto</th>
                            <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wide text-[#73777f]">Preço unit.</th>
                            <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wide text-[#73777f]">Qtd.</th>
                            <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wide text-[#73777f]">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#eef0f4] bg-white">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-5 py-4 text-sm font-bold text-[#1a1b20]">{{ $item->product_name }}</td>
                                <td class="px-5 py-4 text-right text-sm text-[#44474f]">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                                <td class="px-5 py-4 text-right text-sm text-[#44474f]">{{ $item->quantity }}</td>
                                <td class="px-5 py-4 text-right text-sm text-[#44474f]">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-[#f8f9ff]">
                        <tr>
                            <td colspan="3" class="px-5 py-4 text-right text-sm font-bold text-[#1a1b20]">Total</td>
                            <td class="px-5 py-4 text-right text-base font-bold text-[#1a1b20]">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </div>
</x-layouts.main-layout>
