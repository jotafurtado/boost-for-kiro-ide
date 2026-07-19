<?php

declare(strict_types=1);

use Jcf\BoostForKiro\Hooks\HookInstaller;
use Jcf\BoostForKiro\Hooks\HookWriter;
use Jcf\BoostForKiro\Hooks\PromptServer;
use Jcf\BoostForKiro\Hooks\PromptToHookConverter;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Prompt;
use Laravel\Mcp\Server\Prompts\Argument;

it('skips prompts with arguments because static hooks cannot collect them', function () {
    $prompt = new class extends Prompt
    {
        public function arguments(): array
        {
            return [
                new Argument('scope', 'The scope to process', true),
            ];
        }

        public function handle(): Response
        {
            return Response::text('Process the requested scope.');
        }
    };

    $promptServer = Mockery::mock(PromptServer::class);
    $promptServer->shouldReceive('getPrompts')->once()->andReturn(collect([$prompt]));

    $writer = Mockery::mock(HookWriter::class);
    $writer->shouldNotReceive('write');

    $installer = new HookInstaller($promptServer, new PromptToHookConverter, $writer);

    expect($installer->prompts())->toBeEmpty();
});
