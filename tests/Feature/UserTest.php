<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{

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


}