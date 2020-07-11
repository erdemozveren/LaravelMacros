<?php

namespace erdemozveren\laravelmacros;

use Illuminate\Support\ServiceProvider;

class LaravelMacrosServiceProvider extends ServiceProvider
{

    /**
     * Commands
     */
    protected $commands = [
        "erdemozveren\laravelmacros\Commands\GetRules",
        "erdemozveren\laravelmacros\Commands\FormFields",
    ];
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'erdemozveren');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravelmacros');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        require_once(__DIR__."/Helpers/helpers.php");
        require_once(__DIR__."/Helpers/FormMacros.php");

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravelmacros.php', 'laravelmacros');
        $this->commands($this->commands);
        // Register the service the package provides.
        $this->app->singleton('laravelmacros', function ($app) {
            return new laravelmacros;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelmacros'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravelmacros.php' => config_path('laravelmacros.php'),
        ], 'config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/erdemozveren'),
        ], 'laravelmacros.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/erdemozveren'),
        ], 'laravelmacros.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/erdemozveren'),
        ], 'laravelmacros.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
