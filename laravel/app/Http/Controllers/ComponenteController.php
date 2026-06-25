<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComponenteModel as Componente;

class ComponenteController extends Controller
{
    function add(Request $dados)
    {
        $dados->validate([
            'nome'        => 'required|min:3|max:255',
            'hora_inicio' => 'required|date_format:Y-m-d H:i:s',
            'hora_fim'    => 'required|date_format:Y-m-d H:i:s|after:hora_inicio',
        ], [
            'nome.required'        => 'O campo nome é obrigatório.',
            'nome.min'             => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max'             => 'O nome deve ter no máximo 255 caracteres.',
            'hora_inicio.required' => 'O campo hora de início é obrigatório.',
            'hora_inicio.date_format' => 'A hora de início deve estar no formato: AAAA-MM-DD HH:MM:SS.',
            'hora_fim.required'    => 'O campo hora de fim é obrigatório.',
            'hora_fim.date_format' => 'A hora de fim deve estar no formato: AAAA-MM-DD HH:MM:SS.',
            'hora_fim.after'       => 'A hora de fim deve ser posterior à hora de início.',
        ]);

        $componente = Componente::create($dados->only('nome', 'hora_inicio', 'hora_fim'));

        return response()->json($componente, 201);
    }

    function remover(string $id)
    {
        $componente = Componente::find($id);

        if (!$componente) {
            return response()->json(['erro' => 'Componente não encontrado.'], 404);
        }

        $componente->delete();

        return response()->json(['mensagem' => 'Componente removido com sucesso!'], 200); 
    }

    function atualizar(Request $dados, string $id)
    {
        $dados->validate([
            'nome'        => 'required|min:3|max:255',
            'hora_inicio' => 'required|date_format:Y-m-d H:i:s',
            'hora_fim'    => 'required|date_format:Y-m-d H:i:s|after:hora_inicio',
        ], [
            'nome.required'        => 'O campo nome é obrigatório.',
            'nome.min'             => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max'             => 'O nome deve ter no máximo 255 caracteres.',
            'hora_inicio.required' => 'O campo hora de início é obrigatório.',
            'hora_inicio.date_format' => 'A hora de início deve estar no formato: AAAA-MM-DD HH:MM:SS.',
            'hora_fim.required'    => 'O campo hora de fim é obrigatório.',
            'hora_fim.date_format' => 'A hora de fim deve estar no formato: AAAA-MM-DD HH:MM:SS.',
            'hora_fim.after'       => 'A hora de fim deve ser posterior à hora de início.',
        ]);

        $componente = Componente::find($id);

        if (!$componente) {
            return response()->json(['erro' => 'Componente não encontrado.'], 404);
        }

        $componente->update($dados->only('nome', 'hora_inicio', 'hora_fim'));

        return response()->json($componente, 200);
    }
}