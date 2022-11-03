# Add private label functionality to mach3laravel applications

This is a package made for the laravel-starter, the package assumes the laravel-starter template has been used to create the project.

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
    'middleware' => ['web', 'auth', 'locale'],

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
    ],
];

```

Add the following .env vars to your .env
```env
PRIVATE_LABEL_DOMAIN=
FORGE_SERVER_ID=
FORGE_API_TOKEN=
FORGE_SERVER_IP=
MAILGUN_API_TOKEN=
```

Migrate the database

```bash
php artisan migrate
```

## Usage

### Nav 
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

### Php
Add the following trait to the owner model of the config
```php
use Mach3builders\PrivateLabel\Traits\HasPrivateLabel;

use HasPrivateLabel;
```
### Js
Add the following snippet inside your app.js

```js
import '@mach3builders/ui/dist/js/plugins/poller'

$('.private-label-poller').poller({
    running: function(target, data) {
        switch(data.current_status) {
            case 'dns_validating':
                $('#dns_validating').removeClass('d-none')
                $('#dns_validated').addClass('d-none')
            break;

            case 'dns_validated':
                $('#dns_validating').addClass('d-none')
                $('#dns_validated').removeClass('d-none')
            break;

            case 'site_installing':
                $('#site_installing').removeClass('d-none')
                $('#site_installed').addClass('d-none')
            break;
        }
    },
    done: function (target, data) {
        $('#site_installing').addClass('d-none')
        $('#site_installed').removeClass('d-none')
    }
})
```

### Using the label trough the app
When given the ability to make a private label you do want to show the required logo / mail etc
to make it easy copy the following code to your `Brand.php`

```php
<?php

namespace App;

class Brand
{
    public static function name()
    {
        return label()->name
            ?? config('app.name', 'Mach3Builders');
    }

    public static function logoLight()
    {
        return optional(label())->hasMedia('logo_light')
            ? label()->getFirstMediaUrl('logo_light')
            : config('brand.logo_light');
    }

    public static function logoDark()
    {
        return optional(label())->hasMedia('logo_dark')
            ? label()->getFirstMediaUrl('logo_dark')
            : config('brand.logo_dark');
    }

    public static function logoLoginHeight()
    {
        return optional(label())->hasMedia('logo_dark')
            ? label()->logo_login_height
            : config('brand.logo_login_height');
    }

    public static function logoAppHeight()
    {
        return optional(label())->hasMedia('logo_light')
            ? label()->logo_app_height
            : config('brand.logo_app_height');
    }

    public static function favicon()
    {
        return optional(label())->hasMedia('favicon')
            ? label()->getFirstMediaUrl('favicon')
            : config('brand.favicon');
    }

    public static function registration()
    {
        return config('brand.registration');
    }
}
```

### Label api
The package adds an `label()` helper
below are all the methods / properties you can access trough this helper

#### Properties
```php
public string $domain;
public string $name;
public string $email;
public string $logo_login_height; // should be used together with the logo_login
public string $logo_app_height; // should be used together with the logo_app
public string $status; // has one of the following statusses

protected $statusses = [
    'dns_validating',
    'dns_validated',
    'site_installing',
    'site_installed',
];
```
### Events
The email page gives the user the possibility to add a email to their private label. The domain of that email then gets added to the mailgun account of m3b.
The user then has the ability to verify that this domain has been added and is verified.

After the domain has been verified the event EVENT gets triggered. So if your application would like to do something based on that you can adde the follow code to your `EventServiceProvider`
```PHP
protected $listen = [
    // ...
    \Mach3builders\PrivateLabel\Events\EmailDomainVerified::class => [
        \App\Listeners\Listener::class,
    ],
];
```

### Authorization
On every request made to the package the GATE viewPrivateLabel gets checked, please use this inside your application to add a secure entrance for your users. Place the following in your `authserviceprovider.php`
```PHP
function boot() 
{
    // ...
    return Gate::define('viewPrivateLabel', function ($user, $owner_id) {
        return app()->environment(['local', 'testing']);
    });
    // ...
}
```

#### Methods
The following method returns the owner of the private label.
This corresponds with the owner model set in the config
```php
public function owner()
```

Since laravel-privatelabel uses spatie/medialibary all the methods are available.
The following collections are defined inside the `PrivateLabel` model

```php
public function registerMediaCollections(): void
{
    $this->addMediaCollection('logo_light')->singleFile();
    $this->addMediaCollection('logo_dark')->singleFile();
    $this->addMediaCollection('favicon')->singleFile();
}
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
- [ ] Add cname capabilities
- [x] fix poller
- [x] Write api docs
- [x] Release v0.9
- [ ] Add the changes from asana
- [ ] Release v1

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

