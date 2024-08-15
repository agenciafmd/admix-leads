<?php

namespace Agenciafmd\Leads\Providers;

use Agenciafmd\Leads\Models\Lead;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            //
        ]);

        $minutes = Cache::rememberForever('schedule-minutes', static function () {
            return Str::of((string) random_int(0, 59))
                ->padLeft(2, '0')
                ->toString();
        });

        $this->app->booted(function () use ($minutes) {
            $schedule = $this->app->make(Schedule::class);

            $schedule->command('model:prune', [
                '--model' => [
                    Lead::class,
                ],
            ])
                ->dailyAt("03:{$minutes}");
        });
    }
}
