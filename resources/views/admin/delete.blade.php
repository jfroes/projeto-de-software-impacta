<x-layouts.main-layout title="Deletar usuário" class="">
    <div class="space-y-6">
        <header>
            <a href="{{ url('admin/usuarios') }}" class="mb-4 inline-flex items-center gap-2 text-sm font-bold text-[#006a6a] hover:underline"><span class="material-symbols-outlined">arrow_back</span>Usuários</a>
            <h2 class="text-3xl font-bold tracking-tight text-[#1a1b20]">Deletar usuário</h2>
            <p class="inline-flex gap-3 rounded items-center py-3 px-5 mt-2 text-sm text-[#73777f] bg-[#fff0f0] text-[#ba1a1a]"><span class="material-symbols-outlined">
warning
</span>Essa ação é permanente e não pode ser desfeita</p>
        </header>

        <section class="rounded-3xl border border-[#e1e2e9] bg-white p-6 shadow-[0_4px_16px_rgba(25,28,30,0.05)] md:p-8">
            <div class="grid gap-6 text-sm md:grid-cols-2">
                <div><p class="text-[#73777f]">Nome completo</p><p class="mt-1 text-base font-bold text-[#1a1b20]">{{ $user->name }}</p></div>
                <div><p class="text-[#73777f]">Email</p><p class="mt-1 text-base font-bold text-[#1a1b20]">{{ $user->email }}</p></div>
                <div><p class="text-[#73777f]">Perfil</p><p class="mt-1 text-base font-bold text-[#1a1b20]">{{ ucfirst($user->role->value ?? 'usuário') }}</p></div>
                <div><p class="text-[#73777f]">Status</p><p class="mt-1"><span class="inline-flex rounded-full {{ ($user->status->value ?? 'ativo') === 'ativo' ? 'bg-[#e6f7f5] text-[#005454]' : 'bg-[#eef0f4] text-[#5f636b]' }} px-3 py-1 text-xs font-bold">{{ ucfirst($user->status->value ?? 'ativo') }}</span></p></div>
            </div>
        </section>

        <section class="flex flex-wrap gap-3">
            <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3 text-sm font-bold text-white hover:bg-[#005454]"><span class="material-symbols-outlined">arrow_back</span>Voltar</a>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Deseja excluir este usuário?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="cursor-pointer inline-flex items-center justify-center gap-2 rounded-full border border-[#ba1a1a] px-5 py-3 text-sm font-bold text-[#ba1a1a] hover:bg-[#fff0f0]"><span class="material-symbols-outlined">delete</span>Excluir usuário</button>
            </form>
        </section>
    </div>
</x-layouts.main-layout>
