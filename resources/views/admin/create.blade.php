<x-layouts.main-layout title="Novo usuário" class="">
<div class="space-y-6">
    <header>
        <a href="{{ url()->previous() }}" class="mb-4 inline-flex items-center gap-2 text-sm font-bold text-[#006a6a] hover:underline">
            <span class="material-symbols-outlined">arrow_back</span>
            Usuários
        </a>
        <h2 class="text-3xl font-bold tracking-tight text-[#1a1b20]">Novo usuário</h2>
        <p class="mt-2 text-sm text-[#73777f]">Crie um acesso administrativo para o sistema.</p>
    </header>

    <section class="rounded-3xl border border-[#e1e2e9] bg-white p-6 shadow-[0_4px_16px_rgba(25,28,30,0.05)] md:p-8 max-w-3xl">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-[#44474f]">Nome completo</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus class="w-full rounded-xl border border-[#74777f] px-4 py-3 outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                @error('name')<p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-[#44474f]">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-[#74777f] px-4 py-3 outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                @error('email')<p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>@enderror
            </div>
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="role" class="mb-2 block text-sm font-medium text-[#44474f]">Perfil</label>
                    <select id="role" name="role" required class="w-full rounded-xl border border-[#74777f] bg-white px-4 py-3 outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]">
                        <option value="admin" @selected(old('role') === 'admin')>Administrador</option>
                        <option value="funcionario" @selected(old('role', 'usuario') === 'usuario')>Funcionário</option>
                        <option value="gestor" @selected(old('role') === 'admin')>Gestor</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-[#44474f]">Senha temporária</label>
                <input id="password" name="password" type="password" required autocomplete="new-password" class="w-full rounded-xl border border-[#74777f] px-4 py-3 outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                @error('password')<p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>@enderror
            </div>
            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3 text-sm font-bold text-white hover:bg-[#005454]"><span class="material-symbols-outlined">save</span>Salvar usuário</button>
                <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center rounded-full border border-[#74777f] px-5 py-3 text-sm font-bold text-[#44474f] hover:bg-[#f8f9ff]">Cancelar</a>
            </div>
        </form>
    </section>
</div>
</x-layouts.main-layout>
