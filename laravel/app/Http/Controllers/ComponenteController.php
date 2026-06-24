<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $componente = new \App\Models\ComponenteModel();
        $componente::create($dados->only('nome', 'hora_inicio', 'hora_fim'));

        return response()->json($componente->all(), 200);
    }

    function remove(string $id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['erro' => 'ID inválido.'], 422);
        }

        $componente = new \App\Models\ComponenteModel();
        $existe = $componente::find($id);

        if (!$existe) {
            return response()->json(['erro' => 'Componente não encontrado.'], 404);
        }

        $componente::destroy($id);

        return response()->json($componente->all(), 200);
    }

    function atualizar(Request $dados, string $id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['erro' => 'ID inválido.'], 422);
        }

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

        $componente = new \App\Models\ComponenteModel();
        $existe = $componente::find($id);

        if (!$existe) {
            return response()->json(['erro' => 'Componente não encontrado.'], 404);
        }

        $componente::where('id', $id)->update($dados->only('nome', 'hora_inicio', 'hora_fim'));

        return response()->json($componente->all(), 200);
    }
}