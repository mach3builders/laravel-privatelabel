<?php

namespace Mach3builders\PrivateLabel\Tests\Feature;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Mach3builders\PrivateLabel\Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeatureTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Mach3builders\\PrivateLabel\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    public function getEnvironmentSetUp($app)
    {
        // Base app config
        $app['config']->set('app.key', 'base64:BprTTzEwvzVQdkXvX19QR7mmpwgAsHAdyVBKd+EOBvQ=');

        // Package configs
        $app['config']->set('private-label.owner_model', \Mach3builders\PrivateLabel\Tests\Fixtures\Owner::class);
        $app['config']->set('private-label.middleware', ['web']);

        // Testing config
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        include_once __DIR__.'/../../database/migrations/create_privatelabel_table.php';
        (new \CreatePrivatelabelTable())->up();

        include_once __DIR__.'/../../database/migrations/create_media_table.php';
        (new \CreateMediaTable())->up();

        include_once __DIR__.'/../../database/migrations/create_owner_table.php';
        (new \CreateOwnerTable())->up();
    }
}
