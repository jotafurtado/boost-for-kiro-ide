<?php

declare(strict_types=1);

namespace Jcf\BoostForKiro\Console;

use Illuminate\Console\Command;
use Jcf\BoostForKiro\Steering\SteeringInstaller;
use Jcf\BoostForKiro\Steering\SteeringWriter;

class InstallHooksCommand extends Command
{
    protected $signature = 'boost:kiro-hooks';

    protected $description = 'Install Boost MCP prompts as Kiro manual steering files (slash commands)';

    public function handle(SteeringInstaller $installer): int
    {
        $prompts = $installer->prompts();

        if ($prompts->isEmpty()) {
            $this->info('No eligible prompts found.');

            return self::SUCCESS;
        }

        $this->info("Installing {$prompts->count()} prompt(s) as Kiro steering files...");

        $results = $installer->install();

        foreach ($results as $name => $status) {
            $label = match ($status) {
                SteeringWriter::WRITTEN => '✓ created',
                SteeringWriter::UPDATED => '✓ updated',
                SteeringWriter::FAILED => '✗ failed',
            };

            $this->line("  {$name} ... {$label}");
        }

        $this->newLine();
        $this->info('Done. Steering files are available as /boost-prompt-* slash commands in Kiro.');

        return self::SUCCESS;
    }
}
