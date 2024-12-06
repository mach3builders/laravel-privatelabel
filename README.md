# Add private label functionality to mach3laravel applications

This package is designed for the `laravel-starter`. It presupposes that your project was initiated using the `laravel-starter` template.

## Installation

Install the package via composer:

```bash
composer require mach3builders/laravel-privatelabel
```

Publish and execute migrations:

```bash
php artisan vendor:publish --provider="Mach3builders\PrivateLabel\PrivateLabelServiceProvider" --tag="privatelabel-migrations"
```

Publish the configuration file:
```bash
php artisan vendor:publish --provider="Mach3builders\PrivateLabel\PrivateLabelServiceProvider" --tag="privatelabel-config"
```

Here's the published configuration file:

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
     * The domain that runs the main app this is used for the nginx template
     */
    'main_domain' => env('PRIVATE_LABEL_MAIN_DOMAIN'),
    
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

Add the following variables to your .env file:
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

### Navigation
Include the index route in your menu:
```html
    <li class="nav-item">
        <a href="{{ route('private-label.index', {REPLACE_WITH_OWNER_MODEL}) }}" class="nav-link{{ Route::is('private-label.*') ? ' active' : '' }}">
            <span class="ui-icon-text">
                <i class="far fa-tag"></i>
                <span>{{ __('Private label') }}</span>
            </span>
        </a>
    </li>
```

### PHP
Incorporate this trait into your owner model as specified in the config:
```php
use Mach3builders\PrivateLabel\Traits\HasPrivateLabel;

use HasPrivateLabel;
```
### JavaScript
Insert this snippet into your `app.js`:

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

### Brand Customization
To easily manage brand-specific elements like logos and favicons, use this `Brand.php` template:

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

### Label API
The `label()` helper is provided by this package. Here are the methods and properties you can access:

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

After the domain has been verified the `EmailDomainVerified` event gets dispatched. See the following example on how to listen to this event.
```PHP
protected $listen = [
    // ...
    \Mach3builders\PrivateLabel\Events\EmailDomainVerified::class => [
        \App\Listeners\Listener::class,
    ],
];
```

### Authorization
Use the `viewPrivateLabel` gate for secure access. Add this to your `AuthServiceProvider.php`:
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

### Methods
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

### Commands
The packages comes with 2 commands, one to update all php versions of the private labels and one to reinstall all private labels on the forge server.


#### Reinstall labels
the following command will reinstall all private labels on the forge server. The private label will be updated to status `dns_validating` and will go trough the process of being installed on the server.

To reinstall all labels use: 
```bash
php artisan label:reinstall
```

To reinstall a specific label use:
```bash 
php artisan label:reinstall --label=LABEL_ID
```

#### Update label php versions
The following command will update all the php versions of the private labels. The php version will be updated to the latest version available on the forge server. Or to the version specified in the prompts asked to the user when running the command

```bash
php artisan label:update-php
```

## Testing

```bash
composer test
```

## Code styling
All code should be styled using the following command:
```bash
composer pint
```

### Installing caddy on the server
The private label will rely on caddy to handle the ssl.
The main app will also need to be running on port 8080.

To make the main app run on 8080, change the nginx of the main app to listen on 8080.

New way
```nginx
server {
    listen 8080 default_server;
    listen [::]:8080 default_server;
    ....
}
```


Default way for https
```nginx
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    ....
}
```

Default way for http
```nginx
server {
    listen 80 ssl http2;
    listen [::]:80 ssl http2;
    ....
}
```

Next step is to install Caddy on the server
Follow [https://caddyserver.com/docs/install#debian-ubuntu-raspbian](https://caddyserver.com/docs/install#debian-ubuntu-raspbian)


After this create a Caddyfile at `/etc/caddy/Caddyfile` with the following content
```caddy
# Global options block
{
    on_demand_tls {
        ask https://test-app.mach3cart.nl/caddy/allowed-domains # API endpoint to validate the incoming domain
    }
}

# Main app configuration
test-app.mach3cart.nl {
    tls info@mach3builders.nl

    # Forward to NGINX or app
    reverse_proxy localhost:8080
}

# Catch-all for custom subdomains
:443 {
    tls {
        on_demand
    }

    # Forward traffic to NGINX or app
    reverse_proxy localhost:8080
}

# Redirect all HTTP traffic to HTTPS globally
http:// {
    redir https://{host}{uri}
}
```

Small note, the `allowed-domains` endpoint should return a 200 if the domain is allowed.
The allowed domains endpoint receives a `domain` GET parameter.

```bash
curl "https://test-app.mach3cart.nl/caddy/allowed-domains?domain=test-label.sellwise.io"
```


Nginx should be running on 8080
