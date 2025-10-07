<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Battle extends Model
{
    protected $fillable = [
        'title',
        'description', 
        'deadline',
        'user_id'
    ];

    protected $casts = [
        'deadline' => 'datetime'
    ];

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
    public function memes(): HasMany
    {
        return $this->hasMany(Meme::class);
    }

    
    public function isOpen(): bool
    {
        return $this->deadline->isFuture();
    }

    
    public function getRankedMemes()
    {
        return $this->memes()
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->get();
    }
}
