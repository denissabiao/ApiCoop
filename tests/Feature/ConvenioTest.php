<?php

namespace Tests\Feature;

use Tests\TestCase;

class ConvenioTest extends TestCase
{
    public function test_get_all_convenios(){
        $response = $this->getJson(
            '/api/convenio',
            ['Authorizantion' => 'Bearer 2|myr6L2I7tx4Bnliv6ERZCaDYtFeQkQGq5vsn02JH']
        );

        $response->assertStatus(200);

    }
}
