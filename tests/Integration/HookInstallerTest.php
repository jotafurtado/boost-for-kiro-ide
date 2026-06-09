<?php

declare(strict_types=1);

use Jcf\BoostForKiro\Hooks\HookInstaller;
use Jcf\BoostForKiro\Hooks\HookWriter;
use Laravel\Boost\Mcp\Prompts\LaravelCodeSimplifier\LaravelCodeSimplifier;

describe('HookInstaller Integration', function () {
    it('discovers prompts from laravel/boost and installs them', function () {
        // Arrange
        // We set up a temporary directory for kiro hooks
        $tempDir = 'tests/temp_hooks';
        config(['boost.agents.kiro.hooks_path' => $tempDir]);

        /** @var HookInstaller $installer */
        $installer = app(HookInstaller::class);

        // Act
        $prompts = $installer->prompts();

        // Assert: make sure we got some prompts from Boost (we expect LaravelCodeSimplifier, UpgradeLaravelV13, etc.)
        expect($prompts)->not->toBeEmpty();

        $promptNames = $prompts->map(fn ($p) => $p->name())->toArray();
        expect($promptNames)->toContain('laravel-code-simplifier');

        // Let's run install
        $results = $installer->install();

        // Assert results has the prompts mapped to their status
        expect($results)->toHaveKey('laravel-code-simplifier');
        expect($results['laravel-code-simplifier'])->toBeIn([HookWriter::WRITTEN, HookWriter::UPDATED]);

        // Assert file exists in temp directory
        $expectedFile = base_path($tempDir.'/boost-prompt-laravel-code-simplifier.kiro.hook');
        expect(file_exists($expectedFile))->toBeTrue();

        $hookContent = json_decode(file_get_contents($expectedFile), true);
        expect($hookContent)->toBeArray();
        expect($hookContent['name'])->toBe('Boost: Laravel Code Simplifier');
        expect($hookContent['when']['type'])->toBe('userTriggered');
        expect($hookContent['description'])->toContain('Simplifies and refines');
        expect($hookContent['then']['prompt'])->toContain('Laravel Code Simplifier');

        // Clean up
        @unlink($expectedFile);
        @rmdir(base_path($tempDir));
    });
});
