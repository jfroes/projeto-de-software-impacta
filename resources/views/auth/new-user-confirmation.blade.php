<x-layouts.main-layout title="Cadastro confirmado" class="flex min-h-screen items-center justify-center bg-[#f8f9ff] text-[#1a1b20]">
    <main class="flex min-h-screen items-center justify-center px-5 py-8">
        <section class="w-full max-w-lg rounded-[28px] border border-[#e1e2e9] bg-white p-7 shadow-[0_8px_24px_rgba(25,28,30,0.08)] sm:p-9" aria-labelledby="cadastro-confirmado-title">
            <div class="mx-auto mb-6 grid h-16 w-16 place-items-center rounded-full bg-[#e6f7f5] text-[#006a6a]">
                <span class="material-symbols-outlined">check_circle</span>
            </div>

            <h1 id="cadastro-confirmado-title" class="text-center text-2xl font-bold tracking-tight text-[#1a1b20]">Cadastro confirmado</h1>
            <p class="mx-auto mt-3 max-w-md text-center text-sm leading-6 text-[#73777f]">
                Tudo certo{{ !empty($userName) ? ', ' . $userName : '' }}. Seu cadastro foi confirmado com sucesso.
            </p>
            <p class="mt-3 text-center text-sm leading-6 text-[#73777f]">Seu cadastro foi confirmado. Agora crie uma senha para concluir seu acesso ao sistema.</p>

            <a href="{{ route('new-user') }}" class="mt-8 inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3.5 text-sm font-bold text-white transition hover:bg-[#005454] focus:outline-none focus:ring-4 focus:ring-[#c3f0ed]">
                <span class="material-symbols-outlined">lock_reset</span>
                Criar minha senha
            </a>
        </section>
    </main>
</x-layouts.main-layout>
