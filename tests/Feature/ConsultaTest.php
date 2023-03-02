<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsultaTest extends TestCase
{

    public function test_get_consulta_by_id()
    {
        $response = $this->getJson(
            '/api/consulta/1660600',
            ['Authorizantion' => 'Bearer 2|myr6L2I7tx4Bnliv6ERZCaDYtFeQkQGq5vsn02JH']
        );

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "id",
            "idmedico",
            "medico",
            "data",
            "horario",
            "marcado"
        ]);

    }
    public function test_get_consulta_by_espec_and_data()
    {
        $especialidade = 'GINECOLOGISTA';
        $data = '2023-02-26';
        $response = $this->getJson(
            '/api/consulta/especialidade?especialidade='.$especialidade.'&data='.$data.'',
            ['Authorizantion' => 'Bearer 2|myr6L2I7tx4Bnliv6ERZCaDYtFeQkQGq5vsn02JH']
        );

        $response->assertStatus(200);

    }

    public function test_get_consulta_by_medico_and_data()
    {
        $idmedico = '37';
        $data = '2023-02-26';
        $response = $this->getJson(
            '/api/consulta/medico?idmedico='.$idmedico.'&data='.$data.'',
            ['Authorizantion' => 'Bearer 2|myr6L2I7tx4Bnliv6ERZCaDYtFeQkQGq5vsn02JH']
        );

        $response->assertStatus(200);

    }

    
}