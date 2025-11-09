<?php

declare(strict_types=1);

use Jcf\BoostForKiro\CodeEnvironment\Kiro;
use Laravel\Boost\Boost;

it('registers kiro code environment with boost', function () {
    $environments = Boost::getCodeEnvironments();
    
    expect($environments)
        ->toHaveKey('kiro')
        ->and($environments['kiro'])
        ->toBe(Kiro::class);
});

it('kiro code environment can be instantiated', function () {
    $kiro = app(Kiro::class);
    
    expect($kiro)
        ->toBeInstanceOf(Kiro::class)
        ->and($kiro->name())
        ->toBe('kiro')
        ->and($kiro->displayName())
        ->toBe('Kiro');
});

it('kiro code environment has correct configuration paths', function () {
    $kiro = app(Kiro::class);
    
    expect($kiro->mcpConfigPath())
        ->toBe('.kiro/settings/mcp.json')
        ->and($kiro->guidelinesPath())
        ->toBe('.kiro/steering/laravel-boost.md')
        ->and($kiro->frontmatter())
        ->toBeFalse();
});

