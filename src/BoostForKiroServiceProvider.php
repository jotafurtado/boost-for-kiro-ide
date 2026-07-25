<?php

declare(strict_types=1);

namespace Jcf\BoostForKiro;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Jcf\BoostForKiro\Console\InstallHooksCommand;
use Jcf\BoostForKiro\Steering\PromptServer;
use Jcf\BoostForKiro\Steering\PromptToSteeringConverter;
use Jcf\BoostForKiro\Steering\SteeringInstaller;
use Jcf\BoostForKiro\Steering\SteeringWriter;

class BoostForKiroServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SteeringInstaller::class, function ($app): SteeringInstaller {
            $steeringPath = config('boost.agents.kiro.steering_path', '.kiro/steering');
            $legacyHooksPath = config('boost.agents.kiro.hooks_path', '.kiro/hooks');

            return new SteeringInstaller(
                $app->make(PromptServer::class),
                new PromptToSteeringConverter,
                new SteeringWriter($steeringPath, $legacyHooksPath),
            );
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallHooksCommand::class,
            ]);

            Event::listen(CommandFinished::class, function (CommandFinished $event): void {
                if (! in_array($event->command, ['boost:install', 'boost:update'], true)) {
                    return;
                }

                if ($event->exitCode !== 0) {
                    return;
                }

                if (! config('boost.agents.kiro.auto_sync_hooks', true)) {
                    return;
                }

                $this->app->make(SteeringInstaller::class)->install();
            });
        }
    }
}
