<?php

namespace Database\Seeders;

use App\Models\Battle;
use App\Models\Meme;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BattleSeeder extends Seeder
{
    
    public function run(): void
    {
        
        $user = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        
        $battles = [
            [
                'title' => 'Battle des Mèmes de Chat les Plus Drôles',
                'description' => 'Montrez-nous vos meilleurs mèmes de chat ! Le plus drôle gagne. Les mèmes doivent être originaux et faire rire.',
                'deadline' => now()->addDays(7),
                'user_id' => $user->id,
            ],
            [
                'title' => 'Concours de Mèmes de Programmation',
                'description' => 'Les développeurs vont adorer cette battle ! Partagez vos mèmes sur la programmation, les bugs, et la vie de dev.',
                'deadline' => now()->addDays(5),
                'user_id' => $user->id,
            ],
            [
                'title' => 'Battle des Mèmes de Cuisine',
                'description' => 'Cuisine ratée, recettes bizarres, ou moments culinaires épiques ? Partagez vos mèmes de cuisine les plus hilarants !',
                'deadline' => now()->addDays(3),
                'user_id' => $user->id,
            ],
            [
                'title' => 'Mèmes de Voyage et Aventures',
                'description' => 'Voyages qui tournent mal, découvertes surprenantes, ou moments de tourisme parfait ? Montrez-nous vos mèmes de voyage !',
                'deadline' => now()->subDays(1), 
                'user_id' => $user->id,
            ],
        ];

        foreach ($battles as $battleData) {
            $battle = Battle::create($battleData);

            
            if ($battle->isOpen()) {
                $this->createMemesForBattle($battle, $user);
            }
        }
    }

    private function createMemesForBattle(Battle $battle, User $user)
    {
        
        $users = collect([
            ['name' => 'MemeMaster', 'email' => 'meme1@test.com'],
            ['name' => 'CatLover', 'email' => 'meme2@test.com'],
            ['name' => 'DevHumor', 'email' => 'meme3@test.com'],
            ['name' => 'ChefFail', 'email' => 'meme4@test.com'],
        ])->map(function ($userData) {
            return User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );
        });

        
        $memes = [
            [
                'image_path' => 'memes/placeholder1.jpg',
                'user_id' => $users[0]->id,
            ],
            [
                'image_path' => 'memes/placeholder2.jpg',
                'user_id' => $users[1]->id,
            ],
            [
                'image_path' => 'memes/placeholder3.jpg',
                'user_id' => $users[2]->id,
            ],
        ];

        foreach ($memes as $memeData) {
            $meme = Meme::create([
                'image_path' => $memeData['image_path'],
                'battle_id' => $battle->id,
                'user_id' => $memeData['user_id'],
            ]);

            
            $this->createVotesForMeme($meme, $users);
        }
    }

    private function createVotesForMeme(Meme $meme, $users)
    {
        
        $voteCount = rand(0, min(3, $users->count() - 1)); 
        $voters = $users->random($voteCount);

        foreach ($voters as $voter) {
            
            if ($voter->id !== $meme->user_id) {
                Vote::create([
                    'user_id' => $voter->id,
                    'meme_id' => $meme->id,
                ]);
            }
        }
    }
}
