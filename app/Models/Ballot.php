<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ballot extends Model
{
    protected $fillable = ['election_id', 'anonymous_token_hash', 'encrypted_vote', 'integrity_hash', 'cast_at'];

    protected function casts(): array
    {
        return [
            'cast_at' => 'datetime',
        ];
    }

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }
}
