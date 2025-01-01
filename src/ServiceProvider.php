<?php

namespace Hyvor\LaravelSafeSchedule;

use Hyvor\LaravelSafeSchedule\Command\RunCommand;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton(SafeSchedule::class, function () {
            return new SafeSchedule();
        });
    }

    public function boot(): void
    {

        if ($this->app->runningInConsole()) {
            $this->commands([
                RunCommand::class,
            ]);
        }

    }

}