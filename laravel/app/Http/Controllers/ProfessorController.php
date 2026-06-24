<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    function add(Request $dados)
    {
        $dados->validate([
            'nome'     => 'required|min:3|max:255|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
            'email'    => 'required|email|max:255',
            'telefone' => 'required|digits_between:10,11',
        ], [
            'nome.required'           => 'O campo nome é obrigatório.',
            'nome.min'                => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max'                => 'O nome deve ter no máximo 255 caracteres.',
            'nome.regex'              => 'O nome deve conter apenas letras e espaços.',
            'email.required'          => 'O campo e-mail é obrigatório.',
            'email.email'             => 'Informe um e-mail válido.',
            'email.max'               => 'O e-mail deve ter no máximo 255 caracteres.',
            'telefone.required'       => 'O campo telefone é obrigatório.',
            'telefone.digits_between' => 'O telefone deve ter entre 10 e 11 dígitos numéricos.',
        ]);

        $professor = new \App\Models\ProfessorModel();
        $professor::create($dados->only('nome', 'email', 'telefone'));

        return response()->json($professor->all(), 200);
    }

    function remove(string $id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['erro' => 'ID inválido.'], 422);
        }

        $professor = new \App\Models\ProfessorModel();
        $existe = $professor::find($id);

        if (!$existe) {
            return response()->json(['erro' => 'Professor não encontrado.'], 404);
        }

        $professor::destroy($id);

        return response()->json($professor->all(), 200);
    }

    function atualizar(Request $dados, string $id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['erro' => 'ID inválido.'], 422);
        }

        $dados->validate([
            'nome'     => 'required|min:3|max:255|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
            'email'    => 'required|email|max:255',
            'telefone' => 'required|digits_between:10,11',
        ], [
            'nome.required'           => 'O campo nome é obrigatório.',
            'nome.min'                => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max'                => 'O nome deve ter no máximo 255 caracteres.',
            'nome.regex'              => 'O nome deve conter apenas letras e espaços.',
            'email.required'          => 'O campo e-mail é obrigatório.',
            'email.email'             => 'Informe um e-mail válido.',
            'email.max'               => 'O e-mail deve ter no máximo 255 caracteres.',
            'telefone.required'       => 'O campo telefone é obrigatório.',
            'telefone.digits_between' => 'O telefone deve ter entre 10 e 11 dígitos numéricos.',
        ]);

        $professor = new \App\Models\ProfessorModel();
        $existe = $professor::find($id);

        if (!$existe) {
            return response()->json(['erro' => 'Professor não encontrado.'], 404);
        }

        $professor::where('id', $id)->update($dados->only('nome', 'email', 'telefone'));

        return response()->json($professor->all(), 200);
    }
}