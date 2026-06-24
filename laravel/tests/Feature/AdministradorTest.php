<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdministradorTest extends TestCase
{
    use RefreshDatabase;

    private array $adminValido = [
        'nome'     => 'Admin Silva',
        'email'    => 'admin@sistema.com',
        'telefone' => '11987654321',
        'cpf'      => '12345678901',
        'usuario'  => 'adminsilva',
        'senha'    => 'senha123',
        'status'   => 'ativo',
    ];

    // ==================== ADD ====================

    public function test_add_administrador_com_sucesso(): void
    {
        $response = $this->postJson('/api/administrador/add', $this->adminValido);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Admin Silva']);
    }

    public function test_add_administrador_sem_nome(): void
    {
        $dados = $this->adminValido;
        unset($dados['nome']);

        $response = $this->postJson('/api/administrador/add', $dados);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nome']);
    }

    public function test_add_administrador_email_invalido(): void
    {
        $dados = array_merge($this->adminValido, ['email' => 'nao-e-email']);

        $response = $this->postJson('/api/administrador/add', $dados);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_add_administrador_telefone_incorreto(): void
    {
        $dados = array_merge($this->adminValido, ['telefone' => '1199']);

        $response = $this->postJson('/api/administrador/add', $dados);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['telefone']);
    }

    public function test_add_administrador_cpf_incorreto(): void
    {
        $dados = array_merge($this->adminValido, ['cpf' => '123']);

        $response = $this->postJson('/api/administrador/add', $dados);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['cpf']);
    }

    public function test_add_administrador_usuario_com_espacos(): void
    {
        $dados = array_merge($this->adminValido, ['usuario' => 'admin silva']);

        $response = $this->postJson('/api/administrador/add', $dados);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['usuario']);
    }

    public function test_add_administrador_senha_muito_curta(): void
    {
        $dados = array_merge($this->adminValido, ['senha' => '123']);

        $response = $this->postJson('/api/administrador/add', $dados);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['senha']);
    }

    public function test_add_administrador_status_invalido(): void
    {
        $dados = array_merge($this->adminValido, ['status' => 'suspenso']);

        $response = $this->postJson('/api/administrador/add', $dados);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['status']);
    }

    public function test_add_administrador_status_inativo(): void
    {
        $dados = array_merge($this->adminValido, ['status' => 'inativo']);

        $response = $this->postJson('/api/administrador/add', $dados);

        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => 'inativo']);
    }

    // ==================== REMOVE ====================

    public function test_remove_administrador_com_sucesso(): void
    {
        $add = $this->postJson('/api/administrador/add', $this->adminValido);
        $id  = $add->json()[0]['id'];

        $response = $this->getJson("/api/administrador/remove/{$id}");

        $response->assertStatus(200);
    }

    public function test_remove_administrador_inexistente(): void
    {
        $response = $this->getJson('/api/administrador/remove/999');

        $response->assertStatus(404)
                 ->assertJsonFragment(['erro' => 'Administrador não encontrado.']);
    }

    public function test_remove_administrador_id_invalido(): void
    {
        $response = $this->getJson('/api/administrador/remove/abc');

        $response->assertStatus(422)
                 ->assertJsonFragment(['erro' => 'ID inválido.']);
    }

    // ==================== ATUALIZAR ====================

    public function test_atualizar_administrador_com_sucesso(): void
    {
        $add = $this->postJson('/api/administrador/add', $this->adminValido);
        $id  = $add->json()[0]['id'];

        $dadosNovos = array_merge($this->adminValido, [
            'nome'   => 'Admin Atualizado',
            'email'  => 'atualizado@sistema.com',
            'status' => 'inativo',
        ]);

        $response = $this->postJson("/api/administrador/atualizar/{$id}", $dadosNovos);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Admin Atualizado']);
    }

    public function test_atualizar_administrador_inexistente(): void
    {
        $response = $this->postJson('/api/administrador/atualizar/999', $this->adminValido);

        $response->assertStatus(404)
                 ->assertJsonFragment(['erro' => 'Administrador não encontrado.']);
    }

    public function test_atualizar_administrador_cpf_invalido(): void
    {
        $add = $this->postJson('/api/administrador/add', $this->adminValido);
        $id  = $add->json()[0]['id'];

        $dados = array_merge($this->adminValido, ['cpf' => 'cpfinvalido']);

        $response = $this->postJson("/api/administrador/atualizar/{$id}", $dados);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['cpf']);
    }

    public function test_atualizar_administrador_status_invalido(): void
    {
        $add = $this->postJson('/api/administrador/add', $this->adminValido);
        $id  = $add->json()[0]['id'];

        $dados = array_merge($this->adminValido, ['status' => 'bloqueado']);

        $response = $this->postJson("/api/administrador/atualizar/{$id}", $dados);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['status']);
    }
}