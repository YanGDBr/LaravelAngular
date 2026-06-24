<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComponenteTest extends TestCase
{
    use RefreshDatabase;

    // ==================== ADD ====================

    public function test_add_componente_com_sucesso(): void
    {
        $response = $this->postJson('/api/componente/add', [
            'nome'        => 'Matemática',
            'hora_inicio' => '2026-06-22 08:00:00',
            'hora_fim'    => '2026-06-22 10:00:00',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Matemática']);
    }

    public function test_add_componente_sem_nome(): void
    {
        $response = $this->postJson('/api/componente/add', [
            'hora_inicio' => '2026-06-22 08:00:00',
            'hora_fim'    => '2026-06-22 10:00:00',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nome']);
    }

    public function test_add_componente_sem_hora_inicio(): void
    {
        $response = $this->postJson('/api/componente/add', [
            'nome'     => 'Física',
            'hora_fim' => '2026-06-22 10:00:00',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['hora_inicio']);
    }

    public function test_add_componente_sem_hora_fim(): void
    {
        $response = $this->postJson('/api/componente/add', [
            'nome'        => 'Química',
            'hora_inicio' => '2026-06-22 08:00:00',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['hora_fim']);
    }

    public function test_add_componente_hora_fim_antes_de_inicio(): void
    {
        $response = $this->postJson('/api/componente/add', [
            'nome'        => 'Biologia',
            'hora_inicio' => '2026-06-22 10:00:00',
            'hora_fim'    => '2026-06-22 08:00:00',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['hora_fim']);
    }

    public function test_add_componente_formato_data_invalido(): void
    {
        $response = $this->postJson('/api/componente/add', [
            'nome'        => 'História',
            'hora_inicio' => '22/06/2026 08:00',
            'hora_fim'    => '22/06/2026 10:00',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['hora_inicio']);
    }

    // ==================== REMOVE ====================

    public function test_remove_componente_com_sucesso(): void
    {
        $add = $this->postJson('/api/componente/add', [
            'nome'        => 'Geografia',
            'hora_inicio' => '2026-06-22 08:00:00',
            'hora_fim'    => '2026-06-22 10:00:00',
        ]);
        $id = $add->json()[0]['id'];

        $response = $this->getJson("/api/componente/remove/{$id}");

        $response->assertStatus(200);
    }

    public function test_remove_componente_inexistente(): void
    {
        $response = $this->getJson('/api/componente/remove/999');

        $response->assertStatus(404)
                 ->assertJsonFragment(['erro' => 'Componente não encontrado.']);
    }

    public function test_remove_componente_id_invalido(): void
    {
        $response = $this->getJson('/api/componente/remove/abc');

        $response->assertStatus(422)
                 ->assertJsonFragment(['erro' => 'ID inválido.']);
    }

    // ==================== ATUALIZAR ====================

    public function test_atualizar_componente_com_sucesso(): void
    {
        $add = $this->postJson('/api/componente/add', [
            'nome'        => 'Inglês',
            'hora_inicio' => '2026-06-22 08:00:00',
            'hora_fim'    => '2026-06-22 10:00:00',
        ]);
        $id = $add->json()[0]['id'];

        $response = $this->postJson("/api/componente/atualizar/{$id}", [
            'nome'        => 'Inglês Avançado',
            'hora_inicio' => '2026-06-22 09:00:00',
            'hora_fim'    => '2026-06-22 11:00:00',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Inglês Avançado']);
    }

    public function test_atualizar_componente_inexistente(): void
    {
        $response = $this->postJson('/api/componente/atualizar/999', [
            'nome'        => 'Novo Componente',
            'hora_inicio' => '2026-06-22 08:00:00',
            'hora_fim'    => '2026-06-22 10:00:00',
        ]);

        $response->assertStatus(404)
                 ->assertJsonFragment(['erro' => 'Componente não encontrado.']);
    }

    public function test_atualizar_componente_hora_fim_antes_inicio(): void
    {
        $add = $this->postJson('/api/componente/add', [
            'nome'        => 'Português',
            'hora_inicio' => '2026-06-22 08:00:00',
            'hora_fim'    => '2026-06-22 10:00:00',
        ]);
        $id = $add->json()[0]['id'];

        $response = $this->postJson("/api/componente/atualizar/{$id}", [
            'nome'        => 'Português',
            'hora_inicio' => '2026-06-22 12:00:00',
            'hora_fim'    => '2026-06-22 10:00:00',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['hora_fim']);
    }
}