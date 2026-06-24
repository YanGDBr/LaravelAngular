<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlunoTest extends TestCase
{
    use RefreshDatabase;

    // ==================== ADD ====================

    public function test_add_aluno_com_sucesso(): void
    {
        $response = $this->postJson('/api/aluno/add', [
            'nome' => 'João Silva',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'João Silva']);
    }

    public function test_add_aluno_sem_nome(): void
    {
        $response = $this->postJson('/api/aluno/add', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nome']);
    }

    public function test_add_aluno_nome_muito_curto(): void
    {
        $response = $this->postJson('/api/aluno/add', ['nome' => 'AB']);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nome']);
    }

    public function test_add_aluno_nome_com_numeros(): void
    {
        $response = $this->postJson('/api/aluno/add', ['nome' => 'João123']);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nome']);
    }

    public function test_add_aluno_nome_muito_longo(): void
    {
        $response = $this->postJson('/api/aluno/add', ['nome' => str_repeat('A', 256)]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nome']);
    }

    // ==================== REMOVE ====================

    public function test_remove_aluno_com_sucesso(): void
    {
        $add = $this->postJson('/api/aluno/add', ['nome' => 'Maria Souza']);
        $id  = $add->json()[0]['id'];

        $response = $this->getJson("/api/aluno/remove/{$id}");

        $response->assertStatus(200);
    }

    public function test_remove_aluno_inexistente(): void
    {
        $response = $this->getJson('/api/aluno/remove/999');

        $response->assertStatus(404)
                 ->assertJsonFragment(['erro' => 'Aluno não encontrado.']);
    }

    public function test_remove_aluno_id_invalido(): void
    {
        $response = $this->getJson('/api/aluno/remove/abc');

        $response->assertStatus(422)
                 ->assertJsonFragment(['erro' => 'ID inválido.']);
    }

    // ==================== ATUALIZAR ====================

    public function test_atualizar_aluno_com_sucesso(): void
    {
        $add = $this->postJson('/api/aluno/add', ['nome' => 'Carlos Lima']);
        $id  = $add->json()[0]['id'];

        $response = $this->postJson("/api/aluno/atualizar/{$id}", [
            'nome' => 'Carlos Lima Atualizado',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Carlos Lima Atualizado']);
    }

    public function test_atualizar_aluno_inexistente(): void
    {
        $response = $this->postJson('/api/aluno/atualizar/999', [
            'nome' => 'Aluno Novo',
        ]);

        $response->assertStatus(404)
                 ->assertJsonFragment(['erro' => 'Aluno não encontrado.']);
    }

    public function test_atualizar_aluno_sem_nome(): void
    {
        $add = $this->postJson('/api/aluno/add', ['nome' => 'Pedro Alves']);
        $id  = $add->json()[0]['id'];

        $response = $this->postJson("/api/aluno/atualizar/{$id}", []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nome']);
    }
}