<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meme extends Model
{
    protected $fillable = [
        'image_path',
        'battle_id',
        'user_id'
    ];

    
    public function battle(): BelongsTo
    {
        return $this->belongsTo(Battle::class);
    }

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    
    public function getVotesCountAttribute(): int
    {
        return $this->votes()->count();
    }

    
    public function hasUserVoted(User $user): bool
    {
        return $this->votes()->where('user_id', $user->id)->exists();
    }
}
