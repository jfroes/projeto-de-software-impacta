<?php

use App\Models\Client;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function clients()
    {
        return Client::query()
            ->search($this->search)
            ->orderBy('name')
            ->paginate(10);
    }
};
?>

<div class="space-y-6">

    <section class="overflow-hidden rounded-3xl border border-[#e1e2e9] bg-white shadow-[0_2px_4px_rgba(25,28,30,0.05)]">
        <div class="border-b border-[#e1e2e9] p-5 md:p-6">
            <label for="search" class="sr-only">Pesquisar clientes</label>
            <input
                id="search"
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar por nome, documento ou e-mail"
                class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-sm outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]"
            />
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#e1e2e9]">
                <thead class="bg-[#f8f9ff]">
                    <tr>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Nome</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Documento</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">E-mail</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#73777f]">Telefone</th>
                        <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wide text-[#73777f]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eef0f4] bg-white">
                    @forelse ($this->clients as $client)
                        <tr wire:key="client-{{ $client->id }}" class="hover:bg-[#fbfcff]">
                            <td class="px-5 py-4 text-sm font-bold text-[#1a1b20]">
                                {{ $client->name }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-[#44474f]">
                                {{ $client->document_formatted }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-[#44474f]">
                                {{ $client->email ?? '—' }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-[#44474f]">
                                {{ $client->phone ?? '—' }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('clients.show', $client) }}" class="font-bold text-[#006a6a] hover:underline">
                                        Ver
                                    </a>

                                    @if (auth()->user()->role->canManageCatalog())
                                        <a href="{{ route('clients.edit', $client) }}" class="font-bold text-[#006a6a] hover:underline">
                                            Editar
                                        </a>

                                        <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Deseja excluir este cliente?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="cursor-pointer font-bold text-[#ba1a1a] hover:underline">
                                                Excluir
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-[#73777f]">
                                Nenhum cliente encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-[#e1e2e9] px-5 py-4">
            {{ $this->clients->links() }}
        </div>
    </section>
</div>
