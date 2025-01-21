<?php

namespace Agenciafmd\Leads\Providers;

use Agenciafmd\Leads\Models\Lead;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

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

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $minutes = config('admix.schedule.minutes');

            $schedule->command('model:prune', [
                '--model' => [
                    Lead::class,
                ],
            ])->dailyAt("03:{$minutes}");
        });
    }
}
