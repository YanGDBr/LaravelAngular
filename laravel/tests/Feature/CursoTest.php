<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CursoTest extends TestCase
{
    use RefreshDatabase;

    // ==================== ADD ====================

    public function test_add_curso_com_sucesso(): void
    {
        $response = $this->postJson('/api/curso/add', [
            'nome'    => 'Engenharia de Software',
            'periodo' => 'Noturno',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Engenharia de Software']);
    }

    public function test_add_curso_sem_nome(): void
    {
        $response = $this->postJson('/api/curso/add', ['periodo' => 'Matutino']);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nome']);
    }

    public function test_add_curso_sem_periodo(): void
    {
        $response = $this->postJson('/api/curso/add', ['nome' => 'Direito']);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['periodo']);
    }

    public function test_add_curso_periodo_invalido(): void
    {
        $response = $this->postJson('/api/curso/add', [
            'nome'    => 'Medicina',
            'periodo' => 'Madrugada',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['periodo']);
    }

    public function test_add_curso_nome_com_numeros(): void
    {
        $response = $this->postJson('/api/curso/add', [
            'nome'    => 'Curso123',
            'periodo' => 'Integral',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nome']);
    }

    // ==================== REMOVE ====================

    public function test_remove_curso_com_sucesso(): void
    {
        $add = $this->postJson('/api/curso/add', [
            'nome'    => 'Administração',
            'periodo' => 'Vespertino',
        ]);
        $id = $add->json()[0]['id'];

        $response = $this->getJson("/api/curso/remove/{$id}");

        $response->assertStatus(200);
    }

    public function test_remove_curso_inexistente(): void
    {
        $response = $this->getJson('/api/curso/remove/999');

        $response->assertStatus(404)
                 ->assertJsonFragment(['erro' => 'Curso não encontrado.']);
    }

    public function test_remove_curso_id_invalido(): void
    {
        $response = $this->getJson('/api/curso/remove/abc');

        $response->assertStatus(422)
                 ->assertJsonFragment(['erro' => 'ID inválido.']);
    }

    // ==================== ATUALIZAR ====================

    public function test_atualizar_curso_com_sucesso(): void
    {
        $add = $this->postJson('/api/curso/add', [
            'nome'    => 'Contabilidade',
            'periodo' => 'Matutino',
        ]);
        $id = $add->json()[0]['id'];

        $response = $this->postJson("/api/curso/atualizar/{$id}", [
            'nome'    => 'Contabilidade Atualizada',
            'periodo' => 'Noturno',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Contabilidade Atualizada']);
    }

    public function test_atualizar_curso_inexistente(): void
    {
        $response = $this->postJson('/api/curso/atualizar/999', [
            'nome'    => 'Curso Novo',
            'periodo' => 'Integral',
        ]);

        $response->assertStatus(404)
                 ->assertJsonFragment(['erro' => 'Curso não encontrado.']);
    }

    public function test_atualizar_curso_periodo_invalido(): void
    {
        $add = $this->postJson('/api/curso/add', [
            'nome'    => 'Pedagogia',
            'periodo' => 'Matutino',
        ]);
        $id = $add->json()[0]['id'];

        $response = $this->postJson("/api/curso/atualizar/{$id}", [
            'nome'    => 'Pedagogia',
            'periodo' => 'Invalido',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['periodo']);
    }
}