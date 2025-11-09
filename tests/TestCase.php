<?php

declare(strict_types=1);

namespace Tests;

use Jcf\BoostForKiro\BoostForKiroServiceProvider;
use Laravel\Boost\BoostServiceProvider;
use Laravel\Mcp\Server\Registrar;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function defineEnvironment($app)
    {
        $app['env'] = 'local';

        $app->singleton('mcp', Registrar::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            BoostServiceProvider::class,
            BoostForKiroServiceProvider::class,
        ];
    }
}

