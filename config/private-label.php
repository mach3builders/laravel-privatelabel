<?php

return [
    /**
     * The owner model of the private label
     */
    'owner_model' => App\Models\Account::class,

    /**
     * The layout the extend the views off
     */
    'extend_layout' => 'privatelabel::layout',

    /**
     * Middleware the private label route should live under
     */
    'middleware' => ['web', 'auth'],

    /**
     * The domain every label needs to be cnamed to
     */
    'domain' => env('PRIVATE_LABEL_DOMAIN'),

    /**
     * Forge information
     */
    'forge' => [
        'api_token' => env('FORGE_API_TOKEN'),
        'server_id' => env('FORGE_SERVER_ID'),
        'server_ip' => env('FORGE_SERVER_IP'),
    ],
];