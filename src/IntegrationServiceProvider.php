<?php

namespace Mind4me\Bx24_integration;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;


class IntegrationServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/publishable/config/integration.php',
            'integration'
        );

        if ($this->app->runningInConsole()) {
            $this->registerConsoleCommands();
        }

    }


    public function boot(Router $router, Dispatcher $event)
    {
        $this->publishes([
            __DIR__.'/../publishable/config/integration.php' => config_path('integration.php'),
            __DIR__.'/../publishable/migrations/' => base_path('/database/migrations'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'integration');

        include __DIR__ . '/../routes/web.php';

    }

    private function registerConsoleCommands()
    {
        $this->commands(Console\Integration::class);
        $this->commands(Console\UsersIntegration::class);
        $this->commands(Console\Migration::class);
    }

}
