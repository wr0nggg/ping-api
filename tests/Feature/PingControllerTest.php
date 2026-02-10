<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_ping_endpoint_persists_payload(): void
    {
        $payload = [
            'uuid' => Str::uuid()->toString(),
            'battery_percentage' => 78,
        ];

        $response = $this->postJson(route('ping'), $payload);

        $response->assertOk()
            ->assertExactJson(['status' => 'ok']);

        $this->assertDatabaseHas('pings', [
            'uuid' => $payload['uuid'],
            'battery_percent' => $payload['battery_percentage'],
        ]);
    }

    public function test_ping_endpoint_requires_valid_payload(): void
    {
        $payload = [
            'uuid' => '',
            'battery_percentage' => 101,
        ];

        $response = $this->postJson(route('ping'), $payload);

        $response->assertStatus(422);
        $this->assertDatabaseCount('pings', 0);
    }
}
