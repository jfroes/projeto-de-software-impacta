<x-layouts.main-layout title="Relatórios" class="bg-[#f8f9ff] text-[#1a1b20]">
    <div class="mx-auto max-w-5xl space-y-6 p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-2xl font-semibold">Relatórios</h1>
            <a href="{{ route('reports.pdf', ['start' => $start->toDateString(), 'end' => $end->toDateString()]) }}"
               class="rounded-lg border border-[#006a6a] px-4 py-2 text-sm font-medium text-[#006a6a] hover:bg-[#e6f7f5]">
                Exportar PDF
            </a>
        </div>

        {{-- Filtro de período --}}
        <form method="GET" action="{{ route('reports.index') }}" class="rounded-xl border border-gray-200 bg-white p-4">
            <div class="grid gap-3 md:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_auto] md:items-start">
                <div class="min-w-0">
                    <label for="start" class="mb-1 block text-sm font-medium text-gray-700">Data inicial</label>
                    <input id="start" type="date" name="start" value="{{ $start->toDateString() }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#006a6a] focus:outline-none focus:ring-1 focus:ring-[#c3f0ed]">
                    @error('start')
                        <p class="mt-2 text-sm leading-tight text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="min-w-0">
                    <label for="end" class="mb-1 block text-sm font-medium text-gray-700">Data final</label>
                    <input id="end" type="date" name="end" value="{{ $end->toDateString() }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#006a6a] focus:outline-none focus:ring-1 focus:ring-[#c3f0ed]">
                    @error('end')
                        <p class="mt-2 text-sm leading-tight text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="mt-6 h-[38px] rounded-lg bg-[#006a6a] px-4 text-sm font-medium text-white hover:bg-[#005454]">Filtrar</button>
            </div>
        </form>


        {{-- Resumo --}}
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-gray-200 bg-white p-4">
                <p class="text-sm text-gray-500">Vendas faturadas</p>
                <p class="text-2xl font-semibold">{{ $summary['orders_count'] }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-4">
                <p class="text-sm text-gray-500">Faturamento</p>
                <p class="text-2xl font-semibold">R$ {{ number_format($summary['revenue'], 2, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-4">
                <p class="text-sm text-gray-500">Ticket médio</p>
                <p class="text-2xl font-semibold">R$ {{ number_format($summary['average_ticket'], 2, ',', '.') }}</p>
            </div>
        </div>

        {{-- Vendas por dia --}}
        <section>
            <h2 class="mb-2 text-lg font-semibold">Vendas por dia</h2>
            <p class="mb-2 text-xs text-gray-500">Considera pedidos faturados (faturado, saiu para entrega e entregue) pela data de faturamento. Cancelados não entram.</p>
            <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Dia</th>
                            <th class="px-4 py-3 text-right">Pedidos</th>
                            <th class="px-4 py-3 text-right">Faturamento</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($salesByDay as $row)
                            <tr>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($row->day)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-right">{{ $row->orders_count }}</td>
                                <td class="px-4 py-3 text-right">R$ {{ number_format($row->revenue, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-4 py-6 text-center text-gray-500">Nenhuma venda no período.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Produtos mais vendidos --}}
        <section>
            <h2 class="mb-2 text-lg font-semibold">Produtos mais vendidos</h2>
            <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Produto</th>
                            <th class="px-4 py-3 text-right">Qtd. vendida</th>
                            <th class="px-4 py-3 text-right">Faturamento</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($topProducts as $row)
                            <tr>
                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ $row->product_name }}</td>
                                <td class="px-4 py-3 text-right">{{ $row->total_quantity }}</td>
                                <td class="px-4 py-3 text-right">R$ {{ number_format($row->total_revenue, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Nenhum produto vendido no período.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Pedidos por status --}}
        <section>
            <h2 class="mb-2 text-lg font-semibold">Pedidos por status</h2>
            <p class="mb-2 text-xs text-gray-500">Considera os pedidos criados no período.</p>
            <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Pedidos</th>
                            <th class="px-4 py-3 text-right">Valor total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($ordersByStatus as $row)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $row['status']->badgeClasses() }}">
                                        {{ $row['status']->label() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">{{ $row['orders_count'] }}</td>
                                <td class="px-4 py-3 text-right">R$ {{ number_format($row['amount'], 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-layouts.main-layout>
