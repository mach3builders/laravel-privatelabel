# Add private label functionality to mach3laravel applications

This is a package made for the laravel start of mach3builders, the package assumes the laravel-starter template has been used to create the project.

## Installation

You can install the package via composer:

```bash
composer require mach3builders/laravel-privatelabel
```

Publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Mach3builders\PrivateLabel\PrivateLabelServiceProvider" --tag="privatelabel-migrations"
```

Publish the config file with:
```bash
php artisan vendor:publish --provider="Mach3builders\PrivateLabel\PrivateLabelServiceProvider" --tag="privatelabel-config"
```

This is the contents of the published config file:

```php
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
];
```

Add the following .env vars to your .env
```env
PRIVATE_LABEL_DOMAIN=
FORGE_SERVER_ID=
FORGE_API_TOKEN=
FORGE_SERVER_IP=
```

Migrate the database

```bash
php artisan migrate
```

## Usage

Place the index route in the menu
```html
    <li class="nav-item">
        <a href="{{ route('private-label.index', {REPLACE_WITH_OWNER_MODEL}) }}" class="nav-link{{ Route::is('private-label.*') ? ' active' : '' }}">
            <span class="ui-icon-text">
                <i class="far fa-tag"></i>
                <span>{{ _('Private label') }}</span>
            </span>
        </a>
    </li>
```

Add the following trait to the owner model of the config
```php
use Mach3builders\PrivateLabel\Traits\HasPrivateLabel;

use HasPrivateLabel;
```

## Testing

```bash
composer test
```

## Roadmap
- [x] Setup tests
- [x] Make parent model config
- [x] Test job
- [x] Make sure all test runs
- [x] Write install instructions
- [x] Add it to a project
- [ ] Setup github actions
- [ ] Test package on php 7.3
- [ ] Test package on php 7.4
- [ ] Test package on php 8.0
- [ ] Publish package after all tests have ran
- [ ] Release v0.9
- [ ] Add the changes from asana
- [ ] Release v1

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

