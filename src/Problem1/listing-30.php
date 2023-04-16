<?php

$config = [
    'system_id' => 'tenant-420',
    'services' => [
        'storage' => [
            'avatars' => [
                'bucketName' => 'little-kittens',
                'enabled' => true,
            ],
        ],
        'queues' => [
            'game_points_wallet' => [
                'type' => 'game_points',
                'processing' => 'async',
                'enabled' => true,
            ],
        ],
    ],
];


