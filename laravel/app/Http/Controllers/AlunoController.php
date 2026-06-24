<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlunoController extends Controller
{
    function add(Request $dados)
    {
        $dados->validate([
            'nome' => 'required|min:3|max:255|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min'      => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max'      => 'O nome deve ter no máximo 255 caracteres.',
            'nome.regex'    => 'O nome deve conter apenas letras e espaços.',
        ]);

        $aluno = new \App\Models\AlunoModel();
        $aluno::create($dados->only('nome'));

        return response()->json($aluno->all(), 200);
    }

    function remove(string $id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['erro' => 'ID inválido.'], 422);
        }

        $aluno = new \App\Models\AlunoModel();
        $existe = $aluno::find($id);

        if (!$existe) {
            return response()->json(['erro' => 'Aluno não encontrado.'], 404);
        }

        $aluno::destroy($id);

        return response()->json($aluno->all(), 200);
    }

    function atualizar(Request $dados, string $id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['erro' => 'ID inválido.'], 422);
        }

        $dados->validate([
            'nome' => 'required|min:3|max:255|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min'      => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max'      => 'O nome deve ter no máximo 255 caracteres.',
            'nome.regex'    => 'O nome deve conter apenas letras e espaços.',
        ]);

        $aluno = new \App\Models\AlunoModel();
        $existe = $aluno::find($id);

        if (!$existe) {
            return response()->json(['erro' => 'Aluno não encontrado.'], 404);
        }

        $aluno::where('id', $id)->update($dados->only('nome'));

        return response()->json($aluno->all(), 200);
    }
}