<?php

declare(strict_types=1);

namespace Jcf\BoostForKiro\Hooks;

use Illuminate\Support\Collection;
use Laravel\Mcp\Server\Prompt;

class HookInstaller
{
    public function __construct(
        protected PromptServer $promptServer,
        protected PromptToHookConverter $converter,
        protected HookWriter $writer,
    ) {
        //
    }

    /**
     * Install all eligible Boost prompts as Kiro hooks.
     *
     * @return array<string, HookWriter::WRITTEN|HookWriter::UPDATED|HookWriter::FAILED>
     */
    public function install(): array
    {
        $prompts = $this->promptServer->getPrompts();
        $results = [];
        $filenames = [];

        $prompts->each(function (Prompt $prompt) use (&$results, &$filenames): void {
            $safeName = str_replace(['/', '\\'], '-', $prompt->name());
            $filename = 'boost-prompt-'.$safeName;
            $filenames[] = $filename;
            $hookData = $this->converter->convert($prompt);
            $results[$prompt->name()] = $this->writer->write($filename, $hookData);
        });

        $this->writer->removeStale($filenames);

        return $results;
    }

    /**
     * Get the list of eligible prompts without installing.
     *
     * @return Collection<int, Prompt>
     */
    public function prompts(): Collection
    {
        return $this->promptServer->getPrompts();
    }
}
