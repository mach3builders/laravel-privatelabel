<?php

namespace Mach3builders\PrivateLabel\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Mach3builders\PrivateLabel\PrivateLabelServiceProvider::class,
        ];
    }
}


