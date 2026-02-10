<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ping extends Model
{
    protected $fillable = [
        'uuid',
        'battery_percent',
    ];

    protected function casts(): array
    {
        return [
            'uuid' => 'string',
            'battery_percent' => 'integer',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }
}
