<?php

declare(strict_types=1);

// Example 2: SteeringInstaller é registrado no register()
it('binds SteeringInstaller during register phase', function () {
    $source = file_get_contents(__DIR__.'/../../src/BoostForKiroServiceProvider.php');
    $registerMatch = preg_match('/function register\(\).*?\{(.*?)\}/s', $source, $matches);

    expect($registerMatch)->toBe(1);

    expect($matches[1])->toContain('$this->app->singleton(SteeringInstaller::class');
});

// Example 9: Código do ServiceProvider está limpo
it('does not contain legacy registration patterns', function () {
    $source = file_get_contents(__DIR__.'/../../src/BoostForKiroServiceProvider.php');

    expect($source)
        ->not->toContain('$this->app->booted')
        ->not->toContain('$this->app->make(BoostManager')
        ->not->toContain('try {')
        ->not->toContain('use Laravel\Boost\BoostManager')
        ->not->toContain('registerCodeEnvironment');
});
