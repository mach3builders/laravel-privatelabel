<?php

namespace Mach3builders\PrivateLabel;

use Laravel\Forge\Forge;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PrivateLabelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-privatelabel')
            ->hasConfigFile('private-label')
            ->hasRoutes('web')
            ->hasViews()
            ->hasMigration('create_privatelabel_table')
            ->hasTranslations();

        $this->app->bind(Forge::class, function () {
            return new Forge(config('private-label.forge.api_token'));
        });
    }
}
