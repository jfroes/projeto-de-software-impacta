<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClientController extends Controller
{
    /** A listagem e o filtro ficam no componente Livewire <livewire:clients-table />. */
    public function index(): View
    {
        return view('clients.index');
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->normalizeDocument($request);

        $data = $request->validate($this->rules(), $this->messages());

        Client::create($data);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente cadastrado com sucesso.');
    }

    public function show(Client $client): View
    {
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client): View
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $this->normalizeDocument($request);

        $data = $request->validate($this->rules($client), $this->messages());

        $client->update($data);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente atualizado com sucesso.');
    }

    /**
     * Regra de negócio: cliente com pedidos não pode ser excluído.
     * Hoje o delete passa; na Entrega 3 o RESTRICT de orders.client_id barra e cai no catch.
     */
    public function destroy(Client $client): RedirectResponse
    {
        try {
            $client->delete();
        } catch (QueryException $e) {
            if ($e->getCode() !== '23000') {
                throw $e;
            }

            return redirect()
                ->route('clients.index')
                ->with('error', 'Cliente possui pedidos e não pode ser excluído.');
        }

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente excluído com sucesso.');
    }

    /** Deixa só os dígitos ANTES de validar, para o unique comparar com o que está gravado. */
    private function normalizeDocument(Request $request): void
    {
        $request->merge([
            'document' => preg_replace('/\D/', '', (string) $request->input('document')),
        ]);
    }

    /** Regras compartilhadas por store e update (no update, ignora o próprio documento). */
    private function rules(?Client $client = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'document' => [
                'required',
                'regex:/^(\d{11}|\d{14})$/',
                Rule::unique('clients', 'document')->ignore($client),
            ],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }

    private function messages(): array
    {
        return [
            'document.regex' => 'Informe um CPF (11 dígitos) ou CNPJ (14 dígitos).',
            'document.unique' => 'Já existe um cliente com este documento.',
        ];
    }
}
