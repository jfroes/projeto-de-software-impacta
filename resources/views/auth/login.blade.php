<x-layouts.main-layout title="Login" class="flex h-screen items-center justify-center ">
        <section class="w-full max-w-md rounded-[28px] border border-[#e1e2e9] bg-white p-7 shadow-[0_8px_24px_rgba(25,28,30,0.08)] sm:p-9" aria-labelledby="login-title">
            <div class="mb-8">
                <div class="mb-5 grid h-14 w-14 place-items-center rounded-2xl bg-[#c3f0ed] text-[#006a6a]">
                    <span class="material-symbols-outlined">lock</span>
                </div>
                <h2 id="login-title" class="text-2xl font-bold tracking-tight text-[#1a1b20]">Entrar no Estoque</h2>
                <p class="mt-2 text-sm leading-6 text-[#73777f]">Use suas credenciais para continuar.</p>
            </div>

            <form action="{{ route('authenticate') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-[#44474f]">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" placeholder="voce@empresa.com" required autofocus
                           class="w-full rounded-xl border border-[#74777f] bg-white px-4 py-3 text-[#1a1b20] outline-none transition focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                    @error('email')
                    <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-[#44474f]">Senha</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Digite sua senha" required
                               class="w-full rounded-xl border border-[#74777f] bg-white px-4 py-3 text-[#1a1b20] outline-none transition focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                        <button type="button" data-toggle-password="password" aria-label="Mostrar senha" class="absolute inset-y-0 right-0 grid w-12 place-items-center text-[#73777f] hover:text-[#006a6a]">
                            <span class="material-symbols-outlined">visibility</span>
                        </button>
                    </div>
                    @error('password')
                    <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#005454] focus:outline-none focus:ring-4 focus:ring-[#c3f0ed] cursor-pointer">
                    Entrar
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>
            @error('error')
            <div class="border-t border-gray-200  py-4 text-sm text-red-600">
                {{ $message }}
            </div>
            @enderror
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
</x-layouts.main-layout>
