<?php

namespace Matu\Ding;

use Illuminate\Support\ServiceProvider;
use Matu\Ding\Commands\DepartmentCommand;
use Matu\Ding\commands\GroupCommand;
use Matu\Ding\commands\GroupSettingCommand;
use Matu\Ding\Commands\UserCommand;


class DingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/ding.php' => config_path('mt-ding.php'),
            ]);
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'migrations');
            $this->commands(DepartmentCommand::class);
            $this->commands(UserCommand::class);
            $this->commands(GroupCommand::class);
            $this->commands(GroupSettingCommand::class);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLaravelBindings();
    }


    /**
     * Register Laravel bindings.
     *
     * @return void
     */
    protected function registerLaravelBindings()
    {
        $this->app->singleton(SendMessage::class, function ($app) {
            return new SendMessage();
        });
    }

}
