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
         * Optional methods to load your package assets
         */
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cookies-popup');
        $this->loadRoutesFrom(__DIR__ . '/../routes/cookies_popup.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('cookies-popup.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/cookies-popup'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/cookies-popup'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/cookies-popup'),
            ], 'lang');*/

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
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'cookies-popup');

        // Register the main class to use with the facade
        $this->app->singleton('cookies-popup', function () {
            return new CookiesPopup;
        });
    }
}
