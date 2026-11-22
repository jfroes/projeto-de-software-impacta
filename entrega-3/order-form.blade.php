<?php

use App\Models\Client;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public $clientId = '';

    public string $notes = '';

    /** @var array<int, array{product_id: mixed, quantity: mixed}> */
    public array $items = [
        ['product_id' => '', 'quantity' => 1],
    ];

    #[Computed]
    public function clients()
    {
        return Client::orderBy('name')->get();
    }

    #[Computed]
    public function products()
    {
        return Product::active()->orderBy('name')->get();
    }

    #[Computed]
    public function total(): float
    {
        $products = $this->products->keyBy('id');

        return (float) collect($this->items)->sum(function ($item) use ($products) {
            $product = $products->get((int) ($item['product_id'] ?? 0));
            $quantity = max(0, (int) ($item['quantity'] ?? 0));

            return $product ? (float) $product->price * $quantity : 0;
        });
    }

    public function addItem(): void
    {
        $this->items[] = ['product_id' => '', 'quantity' => 1];
    }

    public function removeItem(int $index): void
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function save(OrderService $orders)
    {
        $this->validate([
            'clientId' => ['required', 'exists:clients,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ], [
            'clientId.required' => 'Selecione o cliente.',
            'clientId.exists' => 'Cliente inválido.',
            'items.required' => 'Adicione ao menos um item.',
            'items.*.product_id.required' => 'Selecione o produto.',
            'items.*.product_id.exists' => 'Produto inválido.',
            'items.*.quantity.required' => 'Informe a quantidade.',
            'items.*.quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'items.*.quantity.min' => 'A quantidade mínima é 1.',
        ]);

        try {
            $order = $orders->createOrder(
                (int) $this->clientId,
                Auth::id(),
                $this->items,
                $this->notes !== '' ? $this->notes : null,
            );
        } catch (\DomainException $e) {
            $this->addError('items', $e->getMessage());

            return;
        }

        session()->flash('success', "Pedido #{$order->id} criado com sucesso.");

        return $this->redirectRoute('orders.show', ['order' => $order->id]);
    }
};
?>

<form wire:submit="save" class="space-y-6">
    <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-6">
        <div>
            <label for="clientId" class="mb-1 block text-sm font-medium text-gray-700">Cliente</label>
            <select id="clientId" wire:model="clientId" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                <option value="">Selecione o cliente...</option>
                @foreach ($this->clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }} — {{ $client->document_formatted }}</option>
                @endforeach
            </select>
            @error('clientId') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="notes" class="mb-1 block text-sm font-medium text-gray-700">Observações</label>
            <textarea id="notes" wire:model="notes" rows="2" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"></textarea>
            @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Itens do pedido</h2>
            <button type="button" wire:click="addItem" class="rounded-lg border border-indigo-600 px-3 py-1.5 text-sm font-medium text-indigo-600 hover:bg-indigo-50">
                + Adicionar item
            </button>
        </div>

        @error('items') <p class="rounded-lg bg-red-50 px-3 py-2 text-sm text-red-700">{{ $message }}</p> @enderror

        @foreach ($items as $index => $item)
            @php
                $selected = $this->products->firstWhere('id', (int) ($item['product_id'] ?? 0));
                $quantity = max(0, (int) ($item['quantity'] ?? 0));
            @endphp

            <div wire:key="item-{{ $index }}" class="grid grid-cols-12 items-start gap-3">
                <div class="col-span-12 md:col-span-6">
                    <select wire:model.live="items.{{ $index }}.product_id" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">Selecione o produto...</option>
                        @foreach ($this->products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }}) — estoque: {{ $product->stock_quantity }}</option>
                        @endforeach
                    </select>
                    @error("items.$index.product_id") <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="col-span-4 md:col-span-2">
                    <input type="number" min="1" step="1" wire:model.live.debounce.300ms="items.{{ $index }}.quantity" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    @error("items.$index.quantity") <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="col-span-5 py-2 text-sm text-gray-600 md:col-span-3">
                    @if ($selected)
                        R$ {{ number_format($selected->price, 2, ',', '.') }} un. =
                        <span class="font-medium text-gray-900">R$ {{ number_format((float) $selected->price * $quantity, 2, ',', '.') }}</span>
                    @endif
                </div>

                <div class="col-span-3 text-right md:col-span-1">
                    @if (count($items) > 1)
                        <button type="button" wire:click="removeItem({{ $index }})" class="py-2 text-sm text-red-600 hover:underline">Remover</button>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="flex justify-end border-t border-gray-100 pt-4 text-lg">
            <span class="mr-3 text-gray-600">Total:</span>
            <span class="font-semibold">R$ {{ number_format($this->total, 2, ',', '.') }}</span>
        </div>
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('orders.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Cancelar</a>
        <button type="submit" wire:loading.attr="disabled" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-60">
            Criar pedido
        </button>
    </div>
</form>
