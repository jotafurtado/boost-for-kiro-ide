<?php

declare(strict_types=1);

namespace Jcf\BoostForKiro;

use Illuminate\Support\ServiceProvider;
use Jcf\BoostForKiro\CodeEnvironment\Kiro;
use Laravel\Boost\Boost;

class BoostForKiroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * This method registers the Kiro IDE code environment with Laravel Boost
     * using the extension hook provided by the package.
     */
    public function boot(): void
    {
        // Register Kiro IDE with Laravel Boost only if the Boost class exists
        if (class_exists(Boost::class)) {
            Boost::registerCodeEnvironment('kiro', Kiro::class);
        }
    }
}
