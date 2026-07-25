<?php

declare(strict_types=1);

namespace Jcf\BoostForKiro\Steering;

use Illuminate\Support\Collection;
use Laravel\Mcp\Server\Prompt;

class SteeringInstaller
{
    public function __construct(
        protected PromptServer $promptServer,
        protected PromptToSteeringConverter $converter,
        protected SteeringWriter $writer,
    ) {
        //
    }

    /**
     * Install all eligible Boost prompts as Kiro manual steering files.
     *
     * @return array<string, SteeringWriter::WRITTEN|SteeringWriter::UPDATED|SteeringWriter::FAILED>
     */
    public function install(): array
    {
        $prompts = $this->prompts();
        $results = [];
        $filenames = [];

        $prompts->each(function (Prompt $prompt) use (&$results, &$filenames): void {
            $safeName = str_replace(['/', '\\'], '-', $prompt->name());
            $filename = 'boost-prompt-'.$safeName;
            $filenames[] = $filename;
            $markdown = $this->converter->convert($prompt);
            $results[$prompt->name()] = $this->writer->write($filename, $markdown);
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
        return $this->promptServer->getPrompts()
            ->filter(fn (Prompt $prompt): bool => $this->converter->supports($prompt))
            ->values();
    }
}
