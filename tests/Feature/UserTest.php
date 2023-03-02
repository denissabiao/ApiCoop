<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_create_user()
    {
        
        $response = $this->postJson(
            '/api/user',
            [
                "name" => "denis sabiao",
                "email" => "denis3@gmail.com",
                "password" => "password",
                "data_nascimento" => "2022-12-12",
                "cpf" => "1154211",
                "telefone" => "35987452144",
                "telefone_adicional" => "3698521444"
            ]
        );

        $response->assertStatus(200);

        $response->assertJson([
            "status" => true,
            "message" => "Usuário cadastrado com sucesso"
        ]);
    }

    public function test_user_not_auth_cant_list_user()
    {
        $response = $this->getJson('/api/user/1');

        $response->assertStatus(401);
    }

    public function test_user_auth_can_list_user()
    {
        $response = $this->getJson('/api/user/1', ['Authorization' => 'Bearer 2|myr6L2I7tx4Bnliv6ERZCaDYtFeQkQGq5vsn02JH']);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "status",
            "data" => [
                "id",
                "name",
                "email",
                "cpf",
                "data_nascimento",
                "telefone",
                "telefone_adicional"
            ]
        ]);
    }

    public function test_user_auth_can_edit_user()
    {
        $response = $this->putJson(
            '/api/user/1',
            [
                "name" => "denis sabiao",
                "email" => "denis2@gmail.com",
                "password" => "password",
                "data_nascimento" => "2022-12-12",
                "cpf" => "115471211",
                "telefone" => "35987452144",
                "telefone_adicional" => "3698521444"
            ],
            ['Authorization' => 'Bearer 2|myr6L2I7tx4Bnliv6ERZCaDYtFeQkQGq5vsn02JH']
        );

        $response->assertStatus(200);

        $response->assertJson([
            "status" => true,
            "message" => "Usuário editado com sucesso"
        ]);
    }
 


}