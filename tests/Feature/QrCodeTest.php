<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\QrCode;

class QrCodeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $qrCodeModel = QrCode::where('url', 'http://example.com')->first();
        if ($qrCodeModel) {
            $qrCodeModel->delete();
        }

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

        $qrCodeModel = QrCode::where('url', 'http://example.com')->first();
        $this->assertNotNull($qrCodeModel);

        $response = $this->get("/api/qr/{$qrCodeModel->hash}");
        $response->assertStatus(200);

        $response = $this->json('PUT', "/api/qr/status/{$qrCodeModel->hash}", [
            'status' => 0,
        ]);
        $response->assertStatus(200);

        $qrCodeModel = QrCode::where('url', 'http://example.com')->first();
        $this->assertEquals(0, $qrCodeModel->status);

        $qrCodeModel->delete();
    }
}
