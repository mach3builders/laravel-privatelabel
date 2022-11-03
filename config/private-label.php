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
    'middleware' => ['web', 'auth', 'locale', 'can:viewPrivateLabel,owner_id'],

    /**
     * The prefix used inside the route group
     */
    'route_prefix' => 'app',

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

    /**
     * Forge information
     */
    'mailgun' => [
        'api_token' => env('MAILGUN_API_TOKEN', ''),
        'default_domain' => env('MAILGUN_DOMAIN', ''),
    ],
];
