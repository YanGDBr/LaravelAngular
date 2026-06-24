<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfessorTest extends TestCase
{
    use RefreshDatabase;

    // ==================== ADD ====================

    public function test_add_professor_com_sucesso(): void
    {
        $response = $this->postJson('/api/professor/add', [
            'nome'     => 'Ana Paula',
            'email'    => 'ana.paula@escola.com',
            'telefone' => '11987654321',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Ana Paula']);
    }

    public function test_add_professor_sem_nome(): void
    {
        $response = $this->postJson('/api/professor/add', [
            'email'    => 'ana@escola.com',
            'telefone' => '11987654321',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nome']);
    }

    public function test_add_professor_email_invalido(): void
    {
        $response = $this->postJson('/api/professor/add', [
            'nome'     => 'Bruno Costa',
            'email'    => 'email-invalido',
            'telefone' => '11987654321',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_add_professor_telefone_muito_curto(): void
    {
        $response = $this->postJson('/api/professor/add', [
            'nome'     => 'Carla Dias',
            'email'    => 'carla@escola.com',
            'telefone' => '123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['telefone']);
    }

    public function test_add_professor_telefone_com_letras(): void
    {
        $response = $this->postJson('/api/professor/add', [
            'nome'     => 'Diego Melo',
            'email'    => 'diego@escola.com',
            'telefone' => 'abcdefghij',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['telefone']);
    }

    public function test_add_professor_sem_email(): void
    {
        $response = $this->postJson('/api/professor/add', [
            'nome'     => 'Elisa Ramos',
            'telefone' => '11987654321',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    // ==================== REMOVE ====================

    public function test_remove_professor_com_sucesso(): void
    {
        $add = $this->postJson('/api/professor/add', [
            'nome'     => 'Fábio Torres',
            'email'    => 'fabio@escola.com',
            'telefone' => '11987654321',
        ]);
        $id = $add->json()[0]['id'];

        $response = $this->getJson("/api/professor/remove/{$id}");

        $response->assertStatus(200);
    }

    public function test_remove_professor_inexistente(): void
    {
        $response = $this->getJson('/api/professor/remove/999');

        $response->assertStatus(404)
                 ->assertJsonFragment(['erro' => 'Professor não encontrado.']);
    }

    public function test_remove_professor_id_invalido(): void
    {
        $response = $this->getJson('/api/professor/remove/abc');

        $response->assertStatus(422)
                 ->assertJsonFragment(['erro' => 'ID inválido.']);
    }

    // ==================== ATUALIZAR ====================

    public function test_atualizar_professor_com_sucesso(): void
    {
        $add = $this->postJson('/api/professor/add', [
            'nome'     => 'Gisele Nunes',
            'email'    => 'gisele@escola.com',
            'telefone' => '11987654321',
        ]);
        $id = $add->json()[0]['id'];

        $response = $this->postJson("/api/professor/atualizar/{$id}", [
            'nome'     => 'Gisele Nunes Atualizada',
            'email'    => 'gisele.nova@escola.com',
            'telefone' => '11911112222',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Gisele Nunes Atualizada']);
    }

    public function test_atualizar_professor_inexistente(): void
    {
        $response = $this->postJson('/api/professor/atualizar/999', [
            'nome'     => 'Novo Professor',
            'email'    => 'novo@escola.com',
            'telefone' => '11987654321',
        ]);

        $response->assertStatus(404)
                 ->assertJsonFragment(['erro' => 'Professor não encontrado.']);
    }

    public function test_atualizar_professor_email_invalido(): void
    {
        $add = $this->postJson('/api/professor/add', [
            'nome'     => 'Hugo Pinto',
            'email'    => 'hugo@escola.com',
            'telefone' => '11987654321',
        ]);
        $id = $add->json()[0]['id'];

        $response = $this->postJson("/api/professor/atualizar/{$id}", [
            'nome'     => 'Hugo Pinto',
            'email'    => 'nao-e-email',
            'telefone' => '11987654321',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }
}