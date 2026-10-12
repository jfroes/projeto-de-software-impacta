<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    /** A listagem e o filtro ficam no componente Livewire <livewire:products-table />. */
    public function index(): View
    {
        return view('products.index');
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $data['active'] = $request->boolean('active');

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto cadastrado com sucesso.');
    }

    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate($this->rules($product));
        $data['active'] = $request->boolean('active');

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Tenta excluir de verdade. Quando existirem pedidos (Entrega 3), o RESTRICT de
     * order_items.product_id barra o delete e o produto é apenas desativado,
     * preservando o histórico.
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            $product->delete();
        } catch (QueryException $e) {
            if ($e->getCode() !== '23000') { // 23000 = violação de integridade (FK)
                throw $e;
            }

            $product->update(['active' => false]);

            return redirect()
                ->route('products.index')
                ->with('success', 'Produto já utilizado em pedidos: foi desativado em vez de excluído.');
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto excluído com sucesso.');
    }

    /** Regras compartilhadas por store e update (no update, ignora o próprio SKU). */
    private function rules(?Product $product = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($product)],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
