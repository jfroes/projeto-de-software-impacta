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
            {{ auth()->user()->name[0] }}
        </div>
    </header>

    {{-- Metric Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 py-6">

            <div class="bg-surface-lowest rounded-xl p-4 shadow-md">
                <div class="rounded-xl p-2 w-fit mb-3" style="background: {{ $metric->container_color ?? '#e1e2e9' }}">
                    <span class="material-symbols-outlined text-xl" style="color: {{ $metric->color ?? 'inherit' }}">{{ $metric->icon ?? 'inventory_2' }}</span>
                </div>
                <p class="font-mono text-3xl font-medium text-on-surface mb-1">{{ $metric->value ?? '0' }}</p>
                <p class="text-xs text-on-surface-variant">{{ $metric->label ?? 'Total' }}</p>
            </div>

        <div class="bg-surface-lowest rounded-xl p-4 shadow-md">
            <div class="rounded-xl p-2 w-fit mb-3" style="background: {{ $metric->container_color ?? '#A8F5C0' }}">
                <span class="material-symbols-outlined text-xl" style="color: {{ $metric->color ?? '#1B6E3D' }}">{{ $metric->icon ?? 'inventory_2' }}</span>
            </div>
            <p class="font-mono text-3xl font-medium text-on-surface mb-1">{{ $metric->value ?? '0' }}</p>
            <p class="text-xs text-on-surface-variant">{{ $metric->label ?? 'baixa' }}</p>
        </div>

        <div class="bg-surface-lowest rounded-xl p-4 shadow-md">
            <div class="rounded-xl p-2 w-fit mb-3" style="background: {{ $metric->container_color ?? '#FFDF99' }}">
                <span class="material-symbols-outlined text-xl" style="color: {{ $metric->color ?? '#7A5900' }}">{{ $metric->icon ?? 'inventory_2' }}</span>
            </div>
            <p class="font-mono text-3xl font-medium text-on-surface mb-1">{{ $metric->value ?? '0' }}</p>
            <p class="text-xs text-on-surface-variant">{{ $metric->label ?? 'ativos' }}</p>
        </div>



    </div>
    @session('success')
        <div class="mx-auto max-w-2xl p-4">
            <div class="rounded-lg bg-green-100 p-4 text-green-800">
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endsession
</x-layouts.main-layout>
