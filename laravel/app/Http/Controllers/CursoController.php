<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CursoModel as Curso;

class CursoController extends Controller
{
    function add(Request $dados)
    {
        $dados->validate([
            'nome'    => 'required|min:3|max:255|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
            'periodo' => 'required|in:Matutino,Vespertino,Noturno,Integral',
        ], [
            'nome.required'    => 'O campo nome é obrigatório.',
            'nome.min'         => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max'         => 'O nome deve ter no máximo 255 caracteres.',
            'nome.regex'       => 'O nome deve conter apenas letras e espaços.',
            'periodo.required' => 'O campo período é obrigatório.',
            'periodo.in'       => 'O período deve ser: Matutino, Vespertino, Noturno ou Integral.',
        ]);

        $curso = Curso::create($dados->only('nome', 'periodo'));

        return response()->json($curso, 201);
    }

    function remover(string $id)
    {
        $curso = Curso::find($id);

        if (!$curso) {
            return response()->json(['erro' => 'Curso não encontrado.'], 404);
        }

        $curso->delete();

        return response()->json(['mensagem' => 'Curso removido com sucesso!'], 200); 
    }

    function atualizar(Request $dados, string $id)
    {
        $dados->validate([
            'nome'    => 'required|min:3|max:255|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
            'periodo' => 'required|in:Matutino,Vespertino,Noturno,Integral',
        ], [
            'nome.required'    => 'O campo nome é obrigatório.',
            'nome.min'         => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max'         => 'O nome deve ter no máximo 255 caracteres.',
            'nome.regex'       => 'O nome deve conter apenas letras e espaços.',
            'periodo.required' => 'O campo período é obrigatório.',
            'periodo.in'       => 'O período deve ser: Matutino, Vespertino, Noturno ou Integral.',
        ]);

        $curso = Curso::find($id);

        if (!$curso) {
            return response()->json(['erro' => 'Curso não encontrado.'], 404);
        }

        $curso->update($dados->only('nome', 'periodo'));

        return response()->json($curso, 200);
    }
}