<?php

namespace Tests\Feature;

use Tests\TestCase;

class MedicoTest extends TestCase
{

    public function test_get_all_medicos()
    {
        $response = $this->getJson(
            '/api/medico',
            ['Authorizantion' => 'Bearer 2|myr6L2I7tx4Bnliv6ERZCaDYtFeQkQGq5vsn02JH']
        );

        $response->assertStatus(200);
    }

    public function test_get_medico_by_id()
    {
        $response = $this->getJson(
            '/api/medico/27',
            ['Authorizantion' => 'Bearer 2|myr6L2I7tx4Bnliv6ERZCaDYtFeQkQGq5vsn02JH']
        );

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                "id",
                "medico"
            ]
        ]);
    }

    public function test_get_medico_by_especialidade()
    {
        $especialidade = 'GINECOLOGISTA';
        $response = $this->getJson(
            '/api/medico/especialidade/'.$especialidade.'',
            ['Authorizantion' => 'Bearer 2|myr6L2I7tx4Bnliv6ERZCaDYtFeQkQGq5vsn02JH']
        );

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
            ]
        ]);
    }
}