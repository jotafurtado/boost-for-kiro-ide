<?php

declare(strict_types=1);

namespace Jcf\BoostForKiro\Hooks;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Laravel\Boost\Mcp\Boost;
use Laravel\Mcp\Server\Prompt;

/**
 * Extends the Boost MCP server to expose prompt discovery.
 *
 * We override the constructor to avoid the Transport dependency — we only
 * need prompt discovery, not the actual MCP transport layer.
 *
 * Prompts are resolved directly from the discovered class list to avoid
 * coupling to the internal ServerContext constructor, which has changed
 * across laravel/mcp versions.
 */
class PromptServer extends Boost
{
    public function __construct()
    {
        // Intentionally skip parent constructor — we don't need Transport.
    }

    /**
     * Get the registered and eligible prompts from the Boost MCP server.
     *
     * @return Collection<int, Prompt>
     */
    public function getPrompts(): Collection
    {
        $container = Container::getInstance();

        return collect($this->discoverPrompts())
            ->map(fn (string $promptClass): Prompt => $container->make($promptClass))
            ->filter(fn (Prompt $prompt): bool => $prompt->eligibleForRegistration())
            ->values();
    }
}
