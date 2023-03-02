<?php

namespace Tests\Feature;

use Tests\TestCase;

class EspecialidadeTest extends TestCase
{

    public function test_get_all_especialidades()
    {
        $response = $this->getJson(
            '/api/especialidade',
            ['Authorizantion' => 'Bearer 2|myr6L2I7tx4Bnliv6ERZCaDYtFeQkQGq5vsn02JH']
        );

        $response->assertStatus(200);
    }
}