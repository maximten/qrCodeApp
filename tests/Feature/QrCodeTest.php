<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use QrReader;

class QrCodeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->json('POST', '/api/qr/generate', [
            'url' => 'not a site',
            'status' => 1,
            'type' => 'user',
        ]);
        $response->assertStatus(422);

        $response = $this->json('POST', '/api/qr/generate', [
            'url' => 'http://example.com',
            'status' => 1,
            'type' => 'user',
        ]);
        $response->assertStatus(200);
        $link = $response->content();
    }
}
