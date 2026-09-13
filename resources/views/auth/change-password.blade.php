<x-layouts.main-layout title="Resetar senha" class="flex min-h-screen items-center justify-center bg-[#f8f9ff] text-[#1a1b20]">

<main class="flex min-h-screen items-center justify-center px-5 py-8">
    <section class="w-full max-w-lg rounded-[28px] border border-[#e1e2e9] bg-white p-7 shadow-[0_8px_24px_rgba(25,28,30,0.08)] sm:p-9" aria-labelledby="resetar-senha-title">
        <div class="mx-auto mb-6 grid h-16 w-16 place-items-center rounded-full bg-[#e6f7f5] text-[#006a6a]">
            <span class="material-symbols-outlined">lock_reset</span>
        </div>

        <h1 id="resetar-senha-title" class="text-center text-2xl font-bold tracking-tight text-[#1a1b20]">Crie sua senha</h1>
        <p class="mt-3 text-center text-sm leading-6 text-[#73777f]">Defina uma senha para concluir seu acesso ao sistema.</p>

        <form action="{{ route('password-change') }}" method="POST" class="mt-8 space-y-5">
            @csrf

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-[#44474f]">Nova senha</label>
                <div class="relative">
                    <input id="password" name="password" type="password" autocomplete="new-password" required autofocus class="w-full rounded-xl border border-[#74777f] bg-white px-4 py-3 pr-12 text-[#1a1b20] outline-none transition focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                    <button type="button" data-toggle-password="password" aria-label="Mostrar senha" class="absolute inset-y-0 right-0 grid w-12 place-items-center text-[#73777f] hover:text-[#006a6a]"><span class="material-symbols-outlined">visibility</span></button>
                </div>
                @error('password')
                <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-[#44474f]">Confirme sua nova senha</label>
                <div class="relative">
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="w-full rounded-xl border border-[#74777f] bg-white px-4 py-3 pr-12 text-[#1a1b20] outline-none transition focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                    <button type="button" data-toggle-password="password_confirmation" aria-label="Mostrar confirmação de senha" class="absolute inset-y-0 right-0 grid w-12 place-items-center text-[#73777f] hover:text-[#006a6a]"><span class="material-symbols-outlined">visibility</span></button>
                </div>
                @error('password_confirmation')
                <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3.5 text-sm font-bold text-white transition hover:bg-[#005454] focus:outline-none focus:ring-4 focus:ring-[#c3f0ed]">
                <span class="material-symbols-outlined">save</span>
                Salvar senha
            </button>
        </form>
    </section>
</main>

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
