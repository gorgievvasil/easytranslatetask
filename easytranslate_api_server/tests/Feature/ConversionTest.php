<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConverstionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_conversion()
    {
        $response = $this->json('POST','/api/conversion', ['source_currency' => '', 'target_currency' => 'EUR', 'amount' => '100'], ['Accept' => 'application\json', 'Authorization' => 'Bearer 68|Wzf2Y0dPfHGk5SVdNlMoiqRNhFdajRiytxIMj4nD']);

        $response->assertStatus(200);
    }
}
