<?php

namespace Mach3builders\PrivateLabel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Mach3builders\PrivateLabel\Commands\PrivateLabelCommand;

class PrivateLabelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-privatelabel')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-privatelabel_table')
            ->hasCommand(PrivateLabelCommand::class);
    }
}
