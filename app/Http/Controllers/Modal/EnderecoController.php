<?php

namespace App\Http\Controllers\Modal;

use App\Http\Controllers\Controller;
use App\Models\Enderecos;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    /**
     * Exibe uma lista de todos os endereços.
     */
    public function index()
    {
        $enderecos = Enderecos::with('user')->get();
        return response()->json($enderecos);
    }

    /**
     * Exibe um endereço específico.
     */
    public function show($id)
    {
        $endereco = Enderecos::with('user')->findOrFail($id);
        return response()->json($endereco);
    }

    /**
     * Cria um novo endereço.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'cep' => 'required|string|max:10',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
        ]);

        $endereco = Enderecos::create($validatedData);

        return response()->json($endereco, 201);
    }

    /**
     * Atualiza um endereço específico.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'cep' => 'sometimes|string|max:10',
            'logradouro' => 'sometimes|string|max:255',
            'numero' => 'sometimes|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'sometimes|string|max:255',
            'cidade' => 'sometimes|string|max:255',
            'estado' => 'sometimes|string|max:255',
            'pais' => 'sometimes|string|max:255',
        ]);

        $endereco = Enderecos::findOrFail($id);
        $endereco->update($validatedData);

        return response()->json($endereco);
    }

    /**
     * Remove um endereço específico.
     */
    public function destroy($id)
    {
        $endereco = Enderecos::findOrFail($id);
        $endereco->delete();

        return response()->json(null, 204);
    }
}
