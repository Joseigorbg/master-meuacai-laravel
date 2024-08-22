<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Controllers\Controller;

class ContactFormController extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'assunto' => 'required|string|max:1000',
        ]);

        // Criação de um novo registro no banco de dados
        Contact::create([
            'nome' => $request->input('nome'),
            'telefone' => $request->input('telefone'),
            'assunto' => $request->input('assunto'),
        ]);

        // Redirecionar ou retornar uma resposta
        return redirect()->back()->with('success', 'Contato enviado com sucesso!');
    }
}
