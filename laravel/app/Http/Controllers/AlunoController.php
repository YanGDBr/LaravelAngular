<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlunoModel as Aluno;

class AlunoController extends Controller
{
    function add(Request $dados)
    {
        $dados->validate([
            'nome' => 'required|min:3|max:255',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min'      => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max'      => 'O nome deve ter no máximo 255 caracteres.',
        ]);

        $aluno = Aluno::create($dados->only('nome'));

        return response()->json($aluno, 201);
    }

    function remover(string $id)
    {
        $aluno = Aluno::find($id);

        if (!$aluno) {
            return response()->json(['erro' => 'Aluno não encontrado.'], 404);
        }

        $aluno->delete();

        return response()->json(['mensagem' => 'Aluno removido com sucesso!'], 200); 
    }


    function atualizar(Request $dados, string $id)
    {

        $dados->validate([
            'nome' => 'required|min:3|max:255',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min'      => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max'      => 'O nome deve ter no máximo 255 caracteres.',
        ]);

        $aluno = Aluno::find($id);

        if (!$aluno) {
            return response()->json(['erro' => 'Aluno não encontrado.'], 404);
        }

        $aluno->update($dados->only('nome'));

        return response()->json($aluno, 200);
    }
}