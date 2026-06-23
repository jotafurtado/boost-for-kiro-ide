<?php

declare(strict_types=1);

namespace Jcf\BoostForKiro\Hooks;

use Composer\InstalledVersions;
use Illuminate\Container\Container;
use Illuminate\Support\Str;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Prompt;

class PromptToHookConverter
{
    /**
     * Convert a Prompt instance to a Kiro hook array.
     *
     * @return array<string, mixed>
     */
    public function convert(Prompt $prompt): array
    {
        return [
            'enabled' => true,
            'name' => 'Boost: '.Str::headline($prompt->name()),
            'version' => $this->getBoostVersion(),
            'description' => $prompt->description(),
            'when' => [
                'type' => 'userTriggered',
            ],
            'then' => [
                'type' => 'askAgent',
                'prompt' => $this->renderPromptContent($prompt),
            ],
        ];
    }

    protected function renderPromptContent(Prompt $prompt): string
    {
        /** @var Response $response */
        $response = Container::getInstance()->call([$prompt, 'handle']);

        return (string) $response->content();
    }

    protected function getBoostVersion(): string
    {
        if (InstalledVersions::isInstalled('laravel/boost')) {
            $version = InstalledVersions::getPrettyVersion('laravel/boost') ?? '0.0.0';

            return ltrim($version, 'v');
        }

        return '0.0.0';
    }
}
