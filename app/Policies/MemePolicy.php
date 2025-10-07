<?php

namespace App\Policies;

use App\Models\Meme;
use App\Models\User;

class MemePolicy
{
    
    public function view(User $user, Meme $meme): bool
    {
        
        return true;
    }

    
    public function create(User $user): bool
    {
        
        return true;
    }

    
    public function delete(User $user, Meme $meme): bool
    {
        
        return $user->id === $meme->user_id;
    }

    
    public function vote(User $user, Meme $meme): bool
    {
        
        if ($user->id === $meme->user_id) {
            return false;
        }

        
        if (!$meme->battle->isOpen()) {
            return false;
        }

        
        if ($meme->hasUserVoted($user)) {
            return false;
        }

        return true;
    }

    
    public function update(User $user, Meme $meme): bool
    {
        
        return $user->id === $meme->user_id;
    }
}