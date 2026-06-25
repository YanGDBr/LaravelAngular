<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdministradorModel as Administrador;

class AdministradorController extends Controller
{
    function add(Request $dados)
    {
        $dados->validate([
            'nome'     => 'required|min:3|max:255|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
            'email'    => 'required|email|max:255',
            'telefone' => 'required|digits:11',
            'cpf'      => 'required|digits:11',
            'usuario'  => 'required|min:3|max:255|alpha_num',
            'senha'    => 'required|min:6|max:255',
            'status'   => 'required|in:ativo,inativo',
        ], [
            'nome.required'     => 'O campo nome é obrigatório.',
            'nome.min'          => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max'          => 'O nome deve ter no máximo 255 caracteres.',
            'nome.regex'        => 'O nome deve conter apenas letras e espaços.',
            'email.required'    => 'O campo e-mail é obrigatório.',
            'email.email'       => 'Informe um e-mail válido.',
            'email.max'         => 'O e-mail deve ter no máximo 255 caracteres.',
            'telefone.required' => 'O campo telefone é obrigatório.',
            'telefone.digits'   => 'O telefone deve ter exatamente 11 dígitos numéricos (somente números).',
            'cpf.required'      => 'O campo CPF é obrigatório.',
            'cpf.digits'        => 'O CPF deve ter exatamente 11 dígitos numéricos (somente números).',
            'usuario.required'  => 'O campo usuário é obrigatório.',
            'usuario.min'       => 'O usuário deve ter no mínimo 3 caracteres.',
            'usuario.max'       => 'O usuário deve ter no máximo 255 caracteres.',
            'usuario.alpha_num' => 'O usuário deve conter apenas letras e números, sem espaços.',
            'senha.required'    => 'O campo senha é obrigatório.',
            'senha.min'         => 'A senha deve ter no mínimo 6 caracteres.',
            'senha.max'         => 'A senha deve ter no máximo 255 caracteres.',
            'status.required'   => 'O campo status é obrigatório.',
            'status.in'         => 'O status deve ser: ativo ou inativo.',
        ]);

        $admin = Administrador::create($dados->only('nome', 'email', 'telefone', 'cpf', 'usuario', 'senha', 'status'));

        return response()->json($admin, 201);
    }

    function remover(string $id)
    {
        $admin = Administrador::find($id);

        if (!$admin) {
            return response()->json(['erro' => 'Administrador não encontrado.'], 404);
        }

        $admin->delete();

        return response()->json(['mensagem' => 'Administrador removido com sucesso!'], 200); 
    }

    function atualizar(Request $dados, string $id)
    {
        $dados->validate([
            'nome'     => 'required|min:3|max:255|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
            'email'    => 'required|email|max:255',
            'telefone' => 'required|digits:11',
            'cpf'      => 'required|digits:11',
            'usuario'  => 'required|min:3|max:255|alpha_num',
            'senha'    => 'required|min:6|max:255',
            'status'   => 'required|in:ativo,inativo',
        ], [
            'nome.required'     => 'O campo nome é obrigatório.',
            'nome.min'          => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max'          => 'O nome deve ter no máximo 255 caracteres.',
            'nome.regex'        => 'O nome deve conter apenas letras e espaços.',
            'email.required'    => 'O campo e-mail é obrigatório.',
            'email.email'       => 'Informe um e-mail válido.',
            'email.max'         => 'O e-mail deve ter no máximo 255 caracteres.',
            'telefone.required' => 'O campo telefone é obrigatório.',
            'telefone.digits'   => 'O telefone deve ter exatamente 11 dígitos numéricos (somente números).',
            'cpf.required'      => 'O campo CPF é obrigatório.',
            'cpf.digits'        => 'O CPF deve ter exatamente 11 dígitos numéricos (somente números).',
            'usuario.required'  => 'O campo usuário é obrigatório.',
            'usuario.min'       => 'O usuário deve ter no mínimo 3 caracteres.',
            'usuario.max'       => 'O usuário deve ter no máximo 255 caracteres.',
            'usuario.alpha_num' => 'O usuário deve conter apenas letras e números, sem espaços.',
            'senha.required'    => 'O campo senha é obrigatório.',
            'senha.min'         => 'A senha deve ter no mínimo 6 caracteres.',
            'senha.max'         => 'A senha deve ter no máximo 255 caracteres.',
            'status.required'   => 'O campo status é obrigatório.',
            'status.in'         => 'O status deve ser: ativo ou inativo.',
        ]);

        $admin = Administrador::find($id);

        if (!$admin) {
            return response()->json(['erro' => 'Administrador não encontrado.'], 404);
        }

        $admin->update($dados->only('nome', 'email', 'telefone', 'cpf', 'usuario', 'senha', 'status'));

        return response()->json($admin, 200);
    }
}