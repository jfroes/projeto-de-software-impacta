<x-layouts.main-layout title="Perfil" class="">
    <div class=" max-w-3xl space-y-6">
        <header>
            <h2 class="text-3xl font-bold tracking-tight text-[#1a1b20]">Editar perfil</h2>
            <p class="mt-2 text-sm text-[#73777f]">Atualize seus dados pessoais e gerencie sua senha.</p>
        </header>

        @if (session('success'))
            <div class="rounded-2xl border border-[#9edbd5] bg-[#e6f7f5] px-4 py-3 text-sm text-[#005454]">{{ session('success') }}</div>
        @endif
        <section class="rounded-3xl border border-[#e1e2e9] bg-white p-6 shadow-[0_4px_16px_rgba(25,28,30,0.05)] md:p-8">
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-[#44474f]">Nome completo</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name ?? '') }}" required autofocus class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                    @error('name')
                    <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <span class="mb-2 block text-sm font-medium text-[#44474f]">Email</span>
                    <div class="flex items-center gap-3 rounded-xl border border-[#e1e2e9] bg-[#f8f9ff] px-4 py-3 text-sm text-[#73777f]">
                        <span class="material-symbols-outlined">mail</span>
                        <span class="break-all">{{ $user->email ?? 'Email não informado' }}</span>
                    </div>
                    <p class="mt-2 text-xs text-[#73777f]">O email não pode ser alterado.</p>
                </div>

                <div class="border-t border-[#e1e2e9] pt-6">
                    <div class="mb-5">
                        <h3 class="text-lg font-bold text-[#1a1b20]">Alterar senha</h3>
                        <p class="mt-1 text-sm text-[#73777f]">Preencha os campos abaixo somente se quiser trocar sua senha.</p>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="current_password" class="mb-2 block text-sm font-medium text-[#44474f]">Senha atual</label>
                            <div class="relative">
                                <input id="current_password" name="current_password" type="password"  class="w-full rounded-xl border border-[#74777f] px-4 py-3 pr-12 outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                                <button type="button" data-toggle-password="current_password" aria-label="Mostrar senha atual" class="absolute inset-y-0 right-0 grid w-12 place-items-center text-[#73777f] hover:text-[#006a6a]"><span class="material-symbols-outlined">visibility</span></button>
                            </div>
                            @error('current_password')<p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium text-[#44474f]">Nova senha</label>
                            <div class="relative">
                                <input id="password" name="password" type="password" autocomplete="new-password" class="w-full rounded-xl border border-[#74777f] px-4 py-3 pr-12 outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                                <button type="button" data-toggle-password="password" aria-label="Mostrar nova senha" class="absolute inset-y-0 right-0 grid w-12 place-items-center text-[#73777f] hover:text-[#006a6a]"><span class="material-symbols-outlined">visibility</span></button>
                            </div>
                            @error('password')<p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm font-medium text-[#44474f]">Confirmar nova senha</label>
                            <div class="relative">
                                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="w-full rounded-xl border border-[#74777f] px-4 py-3 pr-12 outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                                <button type="button" data-toggle-password="password_confirmation" aria-label="Mostrar confirmação de senha" class="absolute inset-y-0 right-0 grid w-12 place-items-center text-[#73777f] hover:text-[#006a6a]"><span class="material-symbols-outlined">visibility</span></button>
                            </div>
                            @error('password_confirmation')<p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3 text-sm font-bold text-white hover:bg-[#005454]"><span class="material-symbols-outlined">save</span>Salvar alterações</button>
                </div>
            </form>
        </section>
    </div>

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
</x-layouts.main-layout>
