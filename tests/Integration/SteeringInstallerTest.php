<?php

declare(strict_types=1);

use Jcf\BoostForKiro\Steering\PromptServer;
use Jcf\BoostForKiro\Steering\PromptToSteeringConverter;
use Jcf\BoostForKiro\Steering\SteeringInstaller;
use Jcf\BoostForKiro\Steering\SteeringWriter;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Prompt;

describe('SteeringInstaller Integration', function () {
    it('discovers prompts from laravel/boost and installs them as steering files', function () {
        // Arrange
        $tempDir = 'tests/temp_steering';
        config(['boost.agents.kiro.steering_path' => $tempDir]);

        /** @var SteeringInstaller $installer */
        $installer = app(SteeringInstaller::class);

        // Act
        $prompts = $installer->prompts();

        // Assert: Boost prompts are discovered
        expect($prompts)->not->toBeEmpty();

        $promptNames = $prompts->map(fn ($p) => $p->name())->toArray();
        expect($promptNames)->toContain('laravel-code-simplifier');

        // Install
        $results = $installer->install();

        expect($results)->toHaveKey('laravel-code-simplifier');
        expect($results['laravel-code-simplifier'])->toBeIn([SteeringWriter::WRITTEN, SteeringWriter::UPDATED]);

        // Assert the manual steering markdown file was written
        $expectedFile = base_path($tempDir.'/boost-prompt-laravel-code-simplifier.md');
        expect(file_exists($expectedFile))->toBeTrue();

        $content = file_get_contents($expectedFile);

        // Front matter declares manual inclusion (Kiro 1.0 manual steering)
        expect(str_starts_with($content, "---\ninclusion: manual\n---"))->toBeTrue();

        // Title (added by the converter) and rendered prompt body are present
        expect($content)->toContain('# Boost: Laravel Code Simplifier');
        expect($content)->toContain('# Laravel Code Simplifier');
        expect($content)->toContain('simplification specialist');

        // Clean up
        @unlink($expectedFile);
        @rmdir(base_path($tempDir));
    });

    it('removes stale steering files and legacy kiro hook files during install', function () {
        // Arrange: temp directories with an orphan steering file and a legacy hook file
        $steeringDir = 'tests/temp_stale_steering';
        $legacyDir = 'tests/temp_stale_hooks';

        @mkdir(base_path($steeringDir), 0755, true);
        @mkdir(base_path($legacyDir), 0755, true);

        $orphanSteering = base_path($steeringDir.'/boost-prompt-removed-prompt.md');
        $legacyHook = base_path($legacyDir.'/boost-prompt-legacy.kiro.hook');
        file_put_contents($orphanSteering, 'orphan');
        file_put_contents($legacyHook, '{}');

        config([
            'boost.agents.kiro.steering_path' => $steeringDir,
            'boost.agents.kiro.hooks_path' => $legacyDir,
        ]);

        $keptPrompt = new class extends Prompt
        {
            protected string $name = 'kept-prompt';

            protected string $description = 'A prompt that should be kept.';

            public function handle(): Response
            {
                return Response::text('Kept prompt body.');
            }
        };

        $promptServer = Mockery::mock(PromptServer::class);
        $promptServer->shouldReceive('getPrompts')->andReturn(collect([$keptPrompt]));

        $installer = new SteeringInstaller(
            $promptServer,
            new PromptToSteeringConverter,
            new SteeringWriter($steeringDir, $legacyDir),
        );

        // Act
        $installer->install();

        // Assert: the kept prompt's steering file exists, the orphan and legacy files are gone
        expect(file_exists(base_path($steeringDir.'/boost-prompt-kept-prompt.md')))->toBeTrue();
        expect(file_exists($orphanSteering))->toBeFalse();
        expect(file_exists($legacyHook))->toBeFalse();

        // Clean up
        @unlink(base_path($steeringDir.'/boost-prompt-kept-prompt.md'));
        @rmdir(base_path($steeringDir));
        @rmdir(base_path($legacyDir));
    });
});
