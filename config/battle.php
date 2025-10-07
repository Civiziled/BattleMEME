<?php

return [
    

    'image' => [
        'max_size' => 5120, 
        'allowed_types' => ['jpeg', 'png', 'jpg', 'gif', 'webp'],
        'min_dimensions' => [
            'width' => 100,
            'height' => 100,
        ],
        'storage_disk' => 'public',
        'storage_path' => 'memes',
    ],

    'battle' => [
        'min_deadline_hours' => 1, 
        'max_title_length' => 255,
        'max_description_length' => 1000,
    ],

    'voting' => [
        'one_vote_per_meme' => true,
        'can_vote_own_meme' => false,
        'only_open_battles' => true,
    ],

    'pagination' => [
        'battles_per_page' => 9,
        'memes_per_page' => 12,
    ],

    'ui' => [
        'show_vote_counts' => true,
        'show_creator_info' => true,
        'enable_dark_mode' => true,
    ],
];
