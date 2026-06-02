<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Election extends Model
{
    protected $fillable = ['title', 'village_name', 'status', 'started_at', 'ended_at'];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class)->orderBy('ballot_number');
    }

    public function ballots(): HasMany
    {
        return $this->hasMany(Ballot::class);
    }

    public function rsaKey(): HasOne
    {
        return $this->hasOne(RsaKey::class);
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }
}
