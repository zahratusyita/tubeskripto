<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidate extends Model
{
    protected $fillable = ['election_id', 'ballot_number', 'name', 'photo', 'vision', 'mission'];

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }
}
