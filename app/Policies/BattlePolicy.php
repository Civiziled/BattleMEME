<?php

namespace App\Policies;

use App\Models\Battle;
use App\Models\User;

class BattlePolicy
{
    
    public function view(User $user, Battle $battle): bool
    {
        
        return true;
    }

    
    public function create(User $user): bool
    {
        
        return true;
    }

    
    public function update(User $user, Battle $battle): bool
    {
        
        return $user->id === $battle->user_id;
    }

    
    public function delete(User $user, Battle $battle): bool
    {
        
        return $user->id === $battle->user_id;
    }

    
    public function submitMeme(User $user, Battle $battle): bool
    {
        
        return $battle->isOpen();
    }

    
    public function vote(User $user, Battle $battle): bool
    {
        
        return $battle->isOpen();
    }

    
    public function viewMemes(User $user, Battle $battle): bool
    {
        
        return true;
    }
}