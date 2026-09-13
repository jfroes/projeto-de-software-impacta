<x-layouts.main-layout title="Email enviado" class="">
    <main class="flex min-h-[calc(100vh-10rem)] items-center justify-center py-8">
        <section class="w-full max-w-xl rounded-[28px] border border-[#e1e2e9] bg-white p-7 shadow-[0_8px_24px_rgba(25,28,30,0.08)] sm:p-9" aria-labelledby="email-enviado-title">
            <div class="mx-auto mb-6 grid h-16 w-16 place-items-center rounded-full bg-[#e6f7f5] text-[#006a6a]">
                <span class="material-symbols-outlined">mark_email_read</span>
            </div>

            <h1 id="email-enviado-title" class="text-center text-2xl font-bold tracking-tight text-[#1a1b20]">Email enviado com sucesso</h1>
            <p class="mx-auto mt-3 max-w-md text-center text-sm leading-6 text-[#73777f]">O email de confirmação foi enviado corretamente para o usuário abaixo.</p>

            <div class="mt-7 rounded-2xl border border-[#e1e2e9] bg-[#f8f9ff] p-5 text-left">
                <p class="text-xs font-bold uppercase tracking-wide text-[#73777f]">Destinatário</p>
                <p class="mt-2 text-base font-bold text-[#1a1b20]">{{ $userName ?? ($user->name ?? 'Usuário') }}</p>
                <p class="mt-1 break-words text-sm text-[#44474f]">{{ $email ?? ($user->email ?? 'Email não informado') }}</p>
            </div>

            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('users.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#005454] focus:outline-none focus:ring-4 focus:ring-[#c3f0ed]">
                    <span class="material-symbols-outlined">group</span>
                    Voltar para usuários
                </a>
            </div>
        </section>
    </main>
</x-layouts.main-layout>
