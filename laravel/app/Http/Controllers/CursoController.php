<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $curso = new \App\Models\CursoModel();
        $curso::create($dados->only('nome', 'periodo'));

        return response()->json($curso->all(), 200);
    }

    function remove(string $id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['erro' => 'ID inválido.'], 422);
        }

        $curso = new \App\Models\CursoModel();
        $existe = $curso::find($id);

        if (!$existe) {
            return response()->json(['erro' => 'Curso não encontrado.'], 404);
        }

        $curso::destroy($id);

        return response()->json($curso->all(), 200);
    }

    function atualizar(Request $dados, string $id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['erro' => 'ID inválido.'], 422);
        }

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

        $curso = new \App\Models\CursoModel();
        $existe = $curso::find($id);

        if (!$existe) {
            return response()->json(['erro' => 'Curso não encontrado.'], 404);
        }

        $curso::where('id', $id)->update($dados->only('nome', 'periodo'));

        return response()->json($curso->all(), 200);
    }
}