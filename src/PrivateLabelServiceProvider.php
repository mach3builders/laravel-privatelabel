<?php

namespace Mach3builders\PrivateLabel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Mach3builders\PrivateLabel\Commands\PrivateLabelCommand;

class PrivateLabelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-privatelabel')
            ->hasConfigFile()
            ->hasRoutes('web')
            ->hasViews()
            ->hasMigration('create_privatelabel_table')
            ->hasCommand(PrivateLabelCommand::class);
    }
}
