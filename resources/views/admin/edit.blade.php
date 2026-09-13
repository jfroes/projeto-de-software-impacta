<x-layouts.main-layout title="Editar Usuário" class="">
    <div class="space-y-6 max-w-3xl">
        <header>
            <a href="{{ url()->previous()  }}" class="mb-4 inline-flex items-center gap-2 text-sm font-bold text-[#006a6a] hover:underline"><span class="material-symbols-outlined">arrow_back</span>Usuários</a>
            <h2 class="text-3xl font-bold tracking-tight text-[#1a1b20]">Editar usuário</h2>
            <p class="mt-2 text-sm text-[#73777f]">Atualize os dados e as permissões de acesso.</p>
        </header>

        <section class="rounded-3xl border border-[#e1e2e9] bg-white p-6 shadow-[0_4px_16px_rgba(25,28,30,0.05)] md:p-8">
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-[#44474f]">Nome completo</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border border-[#74777f] px-4 py-3 outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                    @error('name')<p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-[#44474f]">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border border-[#74777f] px-4 py-3 outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                    @error('email')<p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>@enderror
                </div>
                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="role" class="mb-2 block text-sm font-medium text-[#44474f]">Perfil</label>
                        <select id="role" name="role" required class="w-full rounded-xl border border-[#74777f] bg-white px-4 py-3 outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]">
                            <option value="admin" @selected(old('role', $user->role ?? '') === 'admin')>Administrador</option>
                            <option value="funcionario" @selected(old('role', $user->role->value ?? 'funcionario') === 'funcionario')>Funcionário</option>
                            <option value="gestor" @selected(old('role', $user->role->value ?? 'gestor') === 'gestor')>Gestor</option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="mb-2 block text-sm font-medium text-[#44474f]">Status</label>
                        <select id="status" name="status" required class="w-full rounded-xl border border-[#74777f] bg-white px-4 py-3 outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]">
                            <option value="ativo" @selected(old('status', $user->status->label() ?? 'Ativo') === 'Ativo')>Ativo</option>
                            <option value="inativo" @selected(old('status', $user->status->label() ?? 'Inativo') === 'Inativo')>Inativo</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-[#44474f]">Nova senha (opcional)</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" autocomplete="new-password" autofocus class="w-full rounded-xl border border-[#74777f] bg-white px-4 py-3 pr-12 text-[#1a1b20] outline-none transition focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                        <button type="button" data-toggle-password="password" aria-label="Mostrar senha" class="absolute inset-y-0 right-0 grid w-12 place-items-center text-[#73777f] hover:text-[#006a6a]"><span class="material-symbols-outlined">visibility</span></button>
                    </div>
                    @error('password')<p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center justify-between flex-wrap gap-3 pt-2">
                    <div class="flex items-center gap-3 flex-wrap">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3 text-sm font-bold text-white hover:bg-[#005454]"><span class="material-symbols-outlined">save</span>Salvar alterações</button>
                    <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center rounded-full border border-[#74777f] px-5 py-3 text-sm font-bold text-[#44474f] hover:bg-[#f8f9ff]">Cancelar</a>
                    </div>
                    <a href="{{ route('users.show', $user->id) }}" class="text-red-500 hover:text-red-700 self-end">Deletar usuário</a>
                </div>
            </form>
        </section>

    <script>
        document.querySelectorAll('[data-toggle-password]').forEach((toggleButton) => {
            toggleButton.addEventListener('click', () => {
                const passwordInput = document.getElementById(toggleButton.dataset.togglePassword);
                const isPasswordVisible = passwordInput.type === 'text';

                passwordInput.type = isPasswordVisible ? 'password' : 'text';
                toggleButton.setAttribute('aria-label', isPasswordVisible ? 'Mostrar senha' : 'Ocultar senha');
                toggleButton.querySelector('.material-symbols-outlined').textContent = isPasswordVisible ? 'visibility' : 'visibility_off';
            });
        });
    </script>
    </div>
</x-layouts.main-layout>
