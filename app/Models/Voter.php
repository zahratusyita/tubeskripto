<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    protected $fillable = ['identity_number', 'full_name', 'region', 'has_voted', 'voted_at'];

    protected function casts(): array
    {
        return [
            'has_voted' => 'boolean',
            'voted_at' => 'datetime',
        ];
    }
}
