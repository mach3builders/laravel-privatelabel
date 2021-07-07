# Add private label functionality to mach3laravel applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mach3builders/laravel-privatelabel.svg?style=flat-square)](https://packagist.org/packages/mach3builders/laravel-privatelabel)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mach3builders/laravel-privatelabel/run-tests?label=tests)](https://github.com/mach3builders/laravel-privatelabel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mach3builders/laravel-privatelabel/Check%20&%20fix%20styling?label=code%20style)](https://github.com/mach3builders/laravel-privatelabel/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mach3builders/laravel-privatelabel.svg?style=flat-square)](https://packagist.org/packages/mach3builders/laravel-privatelabel)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-privatelabel.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-privatelabel)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require mach3builders/laravel-privatelabel
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Mach3builders\PrivateLabel\PrivateLabelServiceProvider" --tag="laravel-privatelabel-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Mach3builders\PrivateLabel\PrivateLabelServiceProvider" --tag="laravel-privatelabel-config"
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

## Usage

```php
$laravel-privatelabel = new Mach3builders\PrivateLabel();
echo $laravel-privatelabel->echoPhrase('Hello, Spatie!');
```

## Testing

```bash
composer test
```

## Roadmap
- [x] Setup tests
- [x] Make parent model config
- [ ] Test job
- [ ] Make sure all test runs
- [ ] Write install instructions
- [ ] Add it to a project
- [ ] Release v0.9
- [ ] Add the changes from asana
- [ ] Release v1

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

