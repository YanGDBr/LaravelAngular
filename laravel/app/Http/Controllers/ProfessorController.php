<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfessorModel as Professor;

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

        $professor = Professor::create($dados->only('nome', 'email', 'telefone'));

        return response()->json($professor, 201);
    }

    function remover(string $id)
    {
        $professor = Professor::find($id);

        if (!$professor) {
            return response()->json(['erro' => 'Professor não encontrado.'], 404);
        }

        $professor->delete();

        return response()->json(['mensagem' => 'Professor removido com sucesso!'], 200); 
    }

    function atualizar(Request $dados, string $id)
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

        $professor = Professor::find($id);

        if (!$professor) {
            return response()->json(['erro' => 'Professor não encontrado.'], 404);
        }

        $professor->update($dados->only('nome', 'email', 'telefone'));

        return response()->json($professor, 200);
    }
}