<?php

namespace Mach3builders\PrivateLabel;

use Illuminate\Support\Facades\Gate;
use Mach3builders\PrivateLabel\Console\Reinstall;
use Mach3builders\PrivateLabel\Console\UpdateLabelPhp;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PrivateLabelServiceProvider extends PackageServiceProvider
{
    public function bootingPackage()
    {
        return Gate::define('viewPrivateLabel', function ($user, $owner_id) {
            return app()->environment(['local', 'testing']);
        });
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-privatelabel')
            ->hasConfigFile('private-label')
            ->hasRoutes('web')
            ->hasCommands([
                UpdateLabelPhp::class,
                Reinstall::class,
            ])
            ->hasViews()
            ->hasMigration('create_privatelabel_table')
            ->hasTranslations();
    }
}
