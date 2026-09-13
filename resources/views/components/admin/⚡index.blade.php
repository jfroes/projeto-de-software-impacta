<?php

use App\Models\User;
use Livewire\Component;

new class extends Component {
    public string $search = '';
    public string $status = '';

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query
                        ->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->when( $this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->get();

        return $this->view([
            'users' => $users,
        ]);
    }
};
?>

<div title="Administração - Usuários" class="">
    <div class="space-y-6">
        <header class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-medium text-[#006a6a]">Administração</p>
                <h2 class="mt-1 text-3xl font-bold tracking-tight text-[#1a1b20]">Usuários</h2>
                <p class="mt-2 text-sm text-[#73777f]">Gerencie os acessos ao sistema.</p>
            </div>
            <a href="{{ route('users.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#005454]">
                <span class="material-symbols-outlined">person_add</span>
                Novo usuário
            </a>
        </header>

        @if (session('success'))
            <div
                class="rounded-2xl border border-[#9edbd5] bg-[#e6f7f5] px-4 py-3 text-sm text-[#005454]">{{ session('success') }}</div>
        @endif

        @if( session('error'))
            <div
                class="rounded-2xl border border-[#f5a8a8] bg-[#fff0f0] px-4 py-3 text-sm text-[#ba1a1a]">{{ session('error') }}</div>

        @endif

        <section
            class="overflow-hidden rounded-3xl border border-[#e1e2e9] bg-white shadow-[0_2px_4px_rgba(25,28,30,0.05)]">
            <div class="border-b border-[#e1e2e9] p-5 md:p-6">
                <div class="flex flex-col gap-3 md:flex-row">
                    <label for="search" class="sr-only">Pesquisar usuários</label>
                    <input id="search"
                           type="text"
                           wire:model.live="search"
                           placeholder="Buscar por nome ou email"
                           class="min-w-0 flex-1 rounded-xl border border-[#74777f] px-4 py-3 text-sm outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]"/>
                    <select name="status"
                            wire:model.live="status"
                            aria-label="Filtrar por status"
                            class="rounded-xl border border-[#74777f] bg-white px-4 py-3 text-sm outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]">
                        <option value="">Todos os status</option>
                        <option value="ativo">Ativos</option>
                        <option value="inativo">Inativos</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#e1e2e9]">
                    <thead class="bg-[#f8f9ff]">
                    <tr>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Nome
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Email
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">
                            Perfil
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">
                            Status
                        </th>
                        <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wide text-[#73777f]">
                            Ações
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-[#eef0f4] bg-white">
                    @forelse ($users as $user)
                        <tr class="hover:bg-[#fbfcff]">
                            <td class="whitespace-nowrap px-5 py-4 text-sm font-bold text-[#1a1b20]">{{ $user->name }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-[#44474f]">{{ $user->email }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-[#44474f]">{{ $user->role->label() ?? 'usuário' }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm">
                                    <span
                                        class="inline-flex items-center rounded  px-2.5 py-1 text-xs font-medium {{ ($user->status->label() ?? 'Ativo') === 'Ativo' ? 'bg-[#A8F5C0] text-[#1B6E3D]' : 'bg-[#eef0f4] text-[#5f636b]' }} px-3 py-1 text-xs font-bold">
                                        {{ $user->status->label() ?? 'Ativo' }}
                                    </span>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                <div class="flex
                                items-center justify-end gap-3">
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="font-bold text-[#006a6a] hover:underline">Ver detalhes</a>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-[#73777f]">Nenhum usuário
                                encontrado.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($users, 'links'))
                <div class="border-t border-[#e1e2e9] px-5 py-4">{{ $users->withQueryString()->links() }}</div>
            @endif
        </section>

    </div>
</div>
