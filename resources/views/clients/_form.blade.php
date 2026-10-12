@php
    $isEdit = isset($client);
@endphp

<section class="rounded-3xl border border-[#e1e2e9] bg-white p-6 shadow-[0_4px_16px_rgba(25,28,30,0.05)] md:p-8">
    <form action="{{ $isEdit ? route('clients.update', $client) : route('clients.store') }}" method="POST" class="space-y-5">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div>
            <label for="name" class="mb-2 block text-sm font-medium text-[#44474f]">Nome</label>
            <input id="name" name="name" type="text" value="{{ old('name', $client->name ?? '') }}" required autofocus class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
            @error('name')
                <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="document" class="mb-2 block text-sm font-medium text-[#44474f]">Documento</label>
            <input id="document" name="document" type="text" value="{{ old('document', $client->document ?? '') }}" placeholder="CPF ou CNPJ" required class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
            <p class="mt-2 text-xs text-[#73777f]">CPF ou CNPJ</p>
            @error('document')
                <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-[#44474f]">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email', $client->email ?? '') }}" class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                @error('email')
                    <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="mb-2 block text-sm font-medium text-[#44474f]">Telefone</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone', $client->phone ?? '') }}" class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                @error('phone')
                    <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="address" class="mb-2 block text-sm font-medium text-[#44474f]">Endereço</label>
            <textarea id="address" name="address" rows="4" class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]">{{ old('address', $client->address ?? '') }}</textarea>
            @error('address')
                <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#005454]">
                <span class="material-symbols-outlined">save</span>
                Salvar
            </button>

            <a href="{{ route('clients.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#74777f] px-5 py-3 text-sm font-bold text-[#44474f] transition hover:bg-[#f8f9ff]">
                <span class="material-symbols-outlined">close</span>
                Cancelar
            </a>
        </div>
    </form>
</section>
