<x-layouts.main-layout title="Movimentações de estoque" class="bg-[#f8f9ff] text-[#1a1b20]">
    <div class="mx-auto max-w-2xl p-6">
        <h1 class="mb-6 text-2xl font-semibold">Nova movimentação de estoque</h1>

        <form method="POST" action="{{ route('stock-movements.store') }}" class="space-y-4 rounded-xl border border-gray-200 bg-white p-6">
            @csrf

            <div>
                <label for="product_id" class="mb-1 block text-sm font-medium text-gray-700">Produto</label>
                <select id="product_id" name="product_id" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#006a6a] focus:outline-none focus:ring-1 focus:ring-[#c3f0ed]">
                    <option value="">Selecione o produto...</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                            {{ $product->name }} ({{ $product->sku }}) — estoque atual: {{ $product->stock_quantity }}
                        </option>
                    @endforeach
                </select>
                @error('product_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="type" class="mb-1 block text-sm font-medium text-gray-700">Tipo</label>
                    <select id="type" name="type" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#006a6a] focus:outline-none focus:ring-1 focus:ring-[#c3f0ed]">
                        <option value="">Selecione...</option>
                        @foreach (\App\Enums\StockMovementType::cases() as $case)
                            <option value="{{ $case->value }}" @selected(old('type') === $case->value)>{{ $case->label() }}</option>
                        @endforeach
                    </select>
                    @error('type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="quantity" class="mb-1 block text-sm font-medium text-gray-700">Quantidade</label>
                    <input id="quantity" type="number" name="quantity" min="1" step="1" value="{{ old('quantity') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#006a6a] focus:outline-none focus:ring-1 focus:ring-[#c3f0ed]">
                    @error('quantity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="reason" class="mb-1 block text-sm font-medium text-gray-700">Motivo</label>
                <select id="reason" name="reason" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#006a6a] focus:outline-none focus:ring-1 focus:ring-[#c3f0ed]">
                    <option value="">Selecione...</option>
                    @foreach ($reasons as $reason)
                        <option value="{{ $reason }}" @selected(old('reason') === $reason)>{{ $reason }}</option>
                    @endforeach
                </select>
                @error('reason') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('stock-movements.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Cancelar</a>
                <button type="submit" class="rounded-lg bg-[#006a6a] px-4 py-2 text-sm font-medium text-white hover:bg-[#005454]">Registrar</button>
            </div>
        </form>
    </div>
</x-layouts.main-layout>
