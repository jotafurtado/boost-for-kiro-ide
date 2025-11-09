<?php

declare(strict_types=1);

use Jcf\BoostForKiro\CodeEnvironment\Kiro;
use Laravel\Boost\Install\Enums\Platform;

it('provides correct system detection config for darwin', function () {
    $kiro = app(Kiro::class);
    $config = $kiro->systemDetectionConfig(Platform::Darwin);
    
    expect($config)
        ->toHaveKey('paths')
        ->and($config['paths'])
        ->toContain('/Applications/Kiro.app');
});

it('provides correct system detection config for linux', function () {
    $kiro = app(Kiro::class);
    $config = $kiro->systemDetectionConfig(Platform::Linux);
    
    expect($config)
        ->toHaveKey('paths')
        ->and($config['paths'])
        ->toContain('/opt/kiro')
        ->toContain('/usr/local/bin/kiro')
        ->toContain('~/.local/bin/kiro');
});

it('provides correct system detection config for windows', function () {
    $kiro = app(Kiro::class);
    $config = $kiro->systemDetectionConfig(Platform::Windows);
    
    expect($config)
        ->toHaveKey('paths')
        ->and($config['paths'])
        ->toContain('%ProgramFiles%\\Kiro')
        ->toContain('%LOCALAPPDATA%\\Programs\\Kiro');
});

it('provides correct project detection config', function () {
    $kiro = app(Kiro::class);
    $config = $kiro->projectDetectionConfig();
    
    expect($config)
        ->toHaveKey('paths')
        ->and($config['paths'])
        ->toContain('.kiro');
});

