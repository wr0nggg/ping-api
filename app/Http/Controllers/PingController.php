<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PingRequest;
use App\Models\Ping;
use Illuminate\Http\JsonResponse;

class PingController
{
    public function ping(PingRequest $request): JsonResponse
    {
        Ping::create([
            'uuid' => $request->string('uuid')->toString(),
            'battery_percent' => $request->integer('battery_percentage'),
        ]);

        return response()->json(['status' => 'ok']);
    }
}
