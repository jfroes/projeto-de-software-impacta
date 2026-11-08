<x-layouts.main-layout title="Home" class="min-h-screen bg-[#f8f9ff] text-[#1a1b20]">
    <header class="flex h-20 items-center justify-between border-b border-[#e1e2e9] bg-[#f8f9ff]/95 px-5 backdrop-blur md:px-8">
        <div class="flex items-center gap-3">
            <label for="sidebar-toggle" class="grid h-11 w-11 cursor-pointer place-items-center rounded-full text-[#44474f] hover:bg-[#e8e8ef] lg:hidden" aria-label="Abrir menu">
                <span class="material-symbols-outlined">menu</span>
            </label>
            <div>
                <p class="text-sm font-medium text-[#73777f]">Bem-vindo de volta,</p>
                <h1 class="text-xl font-bold tracking-tight text-[#1a1b20]">{{ Auth::user()->name }}</h1>
            </div>
        </div>

        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#d8e2ff] text-sm font-bold text-[#17437a]" aria-label="Perfil do usuário">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </header>

    <main class="space-y-6 px-5 py-6 md:px-8">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-2xl border border-[#dfe3ec] bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-[#dff7f5] text-[#006a6a]">
                        <span class="material-symbols-outlined">shopping_bag</span>
                    </span>
                    <span class="rounded-full bg-[#ecfdf5] px-2.5 py-1 text-xs font-semibold text-[#166534]">Total</span>
                </div>
                <p class="text-3xl font-bold tracking-tight text-[#1a1b20]">{{ $stats['orders_total'] ?? 0 }}</p>
                <p class="mt-2 text-sm text-[#73777f]">Pedidos registrados</p>
            </div>

            <div class="rounded-2xl border border-[#dfe3ec] bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-[#e0ecff] text-[#17437a]">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </span>
                    <span class="rounded-full bg-[#e0f2fe] px-2.5 py-1 text-xs font-semibold text-[#0f4c81]">Abertos</span>
                </div>
                <p class="text-3xl font-bold tracking-tight text-[#1a1b20]">{{ $stats['orders_open'] ?? 0 }}</p>
                <p class="mt-2 text-sm text-[#73777f]">Pedidos em andamento</p>
            </div>

            <div class="rounded-2xl border border-[#dfe3ec] bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-[#fff3d6] text-[#8a5b00]">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </span>
                    <span class="rounded-full bg-[#fef3c7] px-2.5 py-1 text-xs font-semibold text-[#92400e]">Crítico</span>
                </div>
                <p class="text-3xl font-bold tracking-tight text-[#1a1b20]">{{ $stats['low_stock_products'] ?? 0 }}</p>
                <p class="mt-2 text-sm text-[#73777f]">Produtos em estoque baixo</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.3fr_0.7fr]">
            <section class="rounded-2xl border border-[#dfe3ec] bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#006a6a]">Resumo</p>
                        <h2 class="text-xl font-bold text-[#1a1b20]">Rendimento e atenção</h2>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-xl bg-[#f5f7ff] p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm text-[#5c6270]">Pedidos em fila</p>
                                <p class="mt-1 text-2xl font-bold text-[#1a1b20]">{{ $stats['orders_open'] ?? 0 }}</p>
                            </div>
                            <span class="material-symbols-outlined text-3xl text-[#17437a]">hourglass_top</span>
                        </div>
                    </div>

                    <div class="rounded-xl bg-[#f8fafc] p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm text-[#5c6270]">Itens com baixa quantidade</p>
                                <p class="mt-1 text-2xl font-bold text-[#1a1b20]">{{ $stats['low_stock_products'] ?? 0 }}</p>
                            </div>
                            <span class="material-symbols-outlined text-3xl text-[#8a5b00]">warning</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-[#dfe3ec] bg-white p-5 shadow-sm">
                <div class="mb-4">
                    <p class="text-sm font-medium text-[#006a6a]">Ações rápidas</p>
                    <h2 class="text-xl font-bold text-[#1a1b20]">Atalhos</h2>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('orders.index') }}" class="flex items-center justify-between rounded-xl border border-[#dfe3ec] bg-[#f8f9ff] px-4 py-3 text-sm font-semibold text-[#1a1b20] transition hover:border-[#c7d2fe] hover:bg-[#eef4ff]">
                        <span class="flex items-center gap-3"><span class="material-symbols-outlined text-[#17437a]">receipt_long</span> Pedidos</span>
                        <span class="material-symbols-outlined text-[#73777f]">arrow_forward</span>
                    </a>

                    <a href="{{ route('products.index') }}" class="flex items-center justify-between rounded-xl border border-[#dfe3ec] bg-[#f8f9ff] px-4 py-3 text-sm font-semibold text-[#1a1b20] transition hover:border-[#c7d2fe] hover:bg-[#eef4ff]">
                        <span class="flex items-center gap-3"><span class="material-symbols-outlined text-[#8a5b00]">inventory</span> Produtos</span>
                        <span class="material-symbols-outlined text-[#73777f]">arrow_forward</span>
                    </a>

                    <a href="{{ route('clients.index') }}" class="flex items-center justify-between rounded-xl border border-[#dfe3ec] bg-[#f8f9ff] px-4 py-3 text-sm font-semibold text-[#1a1b20] transition hover:border-[#c7d2fe] hover:bg-[#eef4ff]">
                        <span class="flex items-center gap-3"><span class="material-symbols-outlined text-[#006a6a]">people</span> Clientes</span>
                        <span class="material-symbols-outlined text-[#73777f]">arrow_forward</span>
                    </a>
                </div>
            </section>
        </div>
    </main>
</x-layouts.main-layout>
