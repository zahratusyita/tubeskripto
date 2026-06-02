<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RsaKey extends Model
{
    protected $fillable = ['election_id', 'public_key', 'private_key_encrypted'];

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }
}
