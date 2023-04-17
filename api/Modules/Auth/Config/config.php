<?php

use Modules\Shared\Entities\User\User;

return [
    'name' => 'Auth',

    'default_locale' => 'en',

    'url_frontend' => env('APP_FRONTEND_URL', 'http://localhost'),

    'api' => [
        'version' => 1,
    ],

    'elasticsearch' => [
        'hosts' => explode(',', env('ELASTICSEARCH_HOSTS')),
        'retries' => 1,
    ],

    'auth' => [
        'redirect' => env('REDIRECT_AUTH'),
        'providers' => [
            'users' => [
                'driver' => 'eloquent',
                'model' => User::class,
            ]
        ],
    ],



    // Services config
    'services' => [

        'google' => [
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect' => env('GOOGLE_REDIRECT')
        ],

        'github' => [
            'client_id' => env('GITHUB_CLIENT_ID'),
            'client_secret' => env('GITHUB_CLIENT_SECRET'),
        ],

        'facebook' => [
            'client_id' => env('FACEBOOK_CLIENT_ID'),
            'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
            'redirect' => env('FACEBOOK_REDIRECT'),
        ],
    ],

    'storage_avatar' => env('STORAGE_AVATAR'),

    'filesystems' => [
        'disks' => [

            'local' => [
                'driver' => 'local',
                'root' => storage_path('app'),
                'throw' => false,
            ],

            'public' => [
                'driver' => 'local',
                'root' => storage_path('app/public'),
                'url' => env('APP_URL') . '/storage',
                'visibility' => 'public',
                'throw' => false,
            ],

            's3' => [
                'driver' => 's3',
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
                'region' => env('AWS_DEFAULT_REGION'),
                'bucket' => env('AWS_BUCKET'),
                'url' => env('AWS_URL'),
                'endpoint' => env('AWS_ENDPOINT'),
                'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
                'throw' => false,
            ],

            'advert' => [
                'driver' => 'local',
                'root' => storage_path('app/public/data/images'),
                'url' => env('APP_URL') . '/storage/data/images',
                'visibility' => 'public',
            ],

            'avatar' => [
                'driver' => 'local',
                'root' => storage_path('app/public/images/avatar'),
                'url' => env('APP_URL') . '/storage/images/avatar',
                'visibility' => 'public',
            ],

        ]
    ],

    'db_log' => env('DB_LOG', false),


    'email' => [
        'image_success'
        => 'https://user-images.githubusercontent.com/13073820/230766455-5755c427-1118-40b0-bc19-fc5fbaa07ac8.png',

        'image_verify'
        => 'https://user-images.githubusercontent.com/13073820/231185043-6c304048-295b-44d8-92bf-ec1bde67c6c8.svg',
    ],

];
