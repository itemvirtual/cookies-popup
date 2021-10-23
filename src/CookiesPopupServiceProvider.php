<?php

namespace Itemvirtual\CookiesPopup;

use Illuminate\Support\ServiceProvider;
use Itemvirtual\CookiesPopup\Console\Commands\GenerateCookiesPopupLabelsCommand;

class CookiesPopupServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Load views and routes
         */
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cookies-popup');
        $this->loadRoutesFrom(__DIR__ . '/../routes/cookies_popup.php');

        $this->publishes([
            __DIR__ . '/../config/cookies-popup.php' => config_path('cookies-popup.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            // Registering package commands.
            $this->commands([
                GenerateCookiesPopupLabelsCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/cookies-popup.php', 'cookies-popup');

    }
}
