<x-layouts.main-layout title="Cliente" class="bg-[#f8f9ff] text-[#1a1b20]">
    <div class="space-y-6">
        <header>
            <a href="{{ route('clients.index') }}" class="mb-4 inline-flex items-center gap-2 text-sm font-bold text-[#006a6a] hover:underline">
                <span class="material-symbols-outlined">arrow_back</span>
                Clientes
            </a>
            <h2 class="text-3xl font-bold tracking-tight text-[#1a1b20]">{{ $client->name }}</h2>
            <p class="mt-2 text-sm text-[#73777f]">Detalhes completos do cliente.</p>
        </header>

        <section class="rounded-3xl border border-[#e1e2e9] bg-white p-6 shadow-[0_4px_16px_rgba(25,28,30,0.05)] md:p-8">
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <p class="text-sm text-[#73777f]">Nome</p>
                    <p class="mt-1 text-base font-bold text-[#1a1b20]">{{ $client->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">Documento</p>
                    <p class="mt-1 text-base font-bold text-[#1a1b20]">{{ $client->document_formatted }}</p>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">E-mail</p>
                    <p class="mt-1 text-base text-[#1a1b20]">{{ $client->email ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">Telefone</p>
                    <p class="mt-1 text-base text-[#1a1b20]">{{ $client->phone ?: '—' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-[#73777f]">Endereço</p>
                    <p class="mt-1 text-base text-[#1a1b20]">{{ $client->address ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">Criado em</p>
                    <p class="mt-1 text-base text-[#1a1b20]">{{ optional($client->created_at)->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-[#73777f]">Atualizado em</p>
                    <p class="mt-1 text-base text-[#1a1b20]">{{ optional($client->updated_at)->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </section>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('clients.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#005454]">
                <span class="material-symbols-outlined">arrow_back</span>
                Voltar
            </a>

            @if (auth()->user()->role->canManageCatalog())
                <a href="{{ route('clients.edit', $client) }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#006a6a] px-5 py-3 text-sm font-bold text-[#006a6a] transition hover:bg-[#e6f7f5]">
                    <span class="material-symbols-outlined">edit</span>
                    Editar
                </a>
            @endif
        </div>
    </div>
</x-layouts.main-layout>
