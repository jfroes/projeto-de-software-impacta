@php
    $isEdit = isset($product);
@endphp

<section class="rounded-3xl border border-[#e1e2e9] bg-white p-6 shadow-[0_4px_16px_rgba(25,28,30,0.05)] md:p-8">
    <form action="{{ $isEdit ? route('products.update', $product) : route('products.store') }}" method="POST" class="space-y-5">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div>
            <label for="name" class="mb-2 block text-sm font-medium text-[#44474f]">Nome</label>
            <input id="name" name="name" type="text" value="{{ old('name', $product->name ?? '') }}" required autofocus class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
            @error('name')
                <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="sku" class="mb-2 block text-sm font-medium text-[#44474f]">SKU</label>
            <input id="sku" name="sku" type="text" value="{{ old('sku', $product->sku ?? '') }}" required class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
            @error('sku')
                <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="mb-2 block text-sm font-medium text-[#44474f]">Descrição</label>
            <textarea id="description" name="description" rows="4" class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="price" class="mb-2 block text-sm font-medium text-[#44474f]">Preço</label>
                <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->price ?? '') }}" required class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                @error('price')
                    <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stock_quantity" class="mb-2 block text-sm font-medium text-[#44474f]">Estoque</label>
                <input id="stock_quantity" name="stock_quantity" type="number" min="0" value="{{ old('stock_quantity', $product->stock_quantity ?? '') }}" required class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                @error('stock_quantity')
                    <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-3">
            <input id="active" name="active" type="checkbox" value="1" @checked($isEdit ? (old('active') ? old('active') : $product->active) : old('active', true)) class="h-4 w-4 rounded border-[#74777f] text-[#006a6a] focus:ring-[#c3f0ed]" />
            <label for="active" class="text-sm font-medium text-[#44474f]">Produto ativo</label>
        </div>
        @error('active')
            <p class="text-sm text-[#ba1a1a]">{{ $message }}</p>
        @enderror

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#005454]">
                <span class="material-symbols-outlined">save</span>
                Salvar
            </button>

            <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#74777f] px-5 py-3 text-sm font-bold text-[#44474f] transition hover:bg-[#f8f9ff]">
                <span class="material-symbols-outlined">close</span>
                Cancelar
            </a>
        </div>
    </form>
</section>
