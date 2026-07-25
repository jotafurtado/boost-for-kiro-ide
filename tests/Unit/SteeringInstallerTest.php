<?php

declare(strict_types=1);

use Jcf\BoostForKiro\Steering\PromptServer;
use Jcf\BoostForKiro\Steering\PromptToSteeringConverter;
use Jcf\BoostForKiro\Steering\SteeringInstaller;
use Jcf\BoostForKiro\Steering\SteeringWriter;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Prompt;
use Laravel\Mcp\Server\Prompts\Argument;

it('skips prompts with arguments because static steering files cannot collect them', function () {
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

    $writer = Mockery::mock(SteeringWriter::class);
    $writer->shouldNotReceive('write');

    $installer = new SteeringInstaller($promptServer, new PromptToSteeringConverter, $writer);

    expect($installer->prompts())->toBeEmpty();
});
