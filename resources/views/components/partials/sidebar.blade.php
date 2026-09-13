<aside class="fixed inset-y-0 left-0 z-30 flex w-72 -translate-x-full flex-col border-r border-[#e1e2e9] bg-[#f8f9ff] px-4 py-5 shadow-xl transition-transform peer-checked:translate-x-0 lg:static lg:translate-x-0 lg:shadow-none">
    <div class="flex items-center gap-3 px-3 pb-7">
        <div class="grid h-11 w-11 place-items-center rounded-2xl bg-[#006a6a] text-white shadow-sm">
            <span class="material-symbols-outlined">inventory_2</span>
        </div>
        <div>
            <p class="text-lg font-bold tracking-tight text-[#171d1d]">Estoque</p>
            <p class="text-xs font-medium text-[#426363]">Gestão operacional</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1" aria-label="Navegação principal">
        <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-[0.12em] text-[#73777f]">Menu</p>
        <a href="{{ route('home')}} " class="flex items-center gap-3 rounded-full {{ request()->routeIs('home') ? 'bg-[#c3f0ed]' : '' }} px-4 py-3 text-sm font-bold text-[#00201f]">
            <span class="material-symbols-outlined">dashboard</span>
            Visão geral
        </a>

        <a href="{{route('profile.edit')}}" class="flex items-center gap-3 rounded-full {{ request()->routeIs('profile.edit') ? 'bg-[#c3f0ed]' : '' }} px-4 py-3 text-sm font-bold text-[#00201f]">
            <span class="material-symbols-outlined">person</span>
            Meu Perfil
        </a>

        @if(Auth::user()->role->canManageUsers())
        <a href="{{ route('users.index')}} " class="flex items-center gap-3 rounded-full {{ request()->routeIs('users.index') ? 'bg-[#c3f0ed]' : '' }} px-4 py-3 text-sm font-bold text-[#00201f]">
            <span class="material-symbols-outlined">people</span>
            Usuários
        </a>
        @endif
    </nav>

    <div class="border-t border-[#e1e2e9] pt-4">
        <a href="{{ route('logout') }}" class="flex items-center gap-3 rounded-full px-4 py-3 text-sm font-medium text-[#44474f] transition-colors hover:bg-[#e8e8ef]">
            <span class="material-symbols-outlined">logout</span>
            Sair
        </a>
    </div>
</aside>
