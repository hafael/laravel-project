<?php

namespace Autum\SAML\Providers;

use Illuminate\Support\ServiceProvider;

class AutumSamlServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        
        $this->publishes([
            __DIR__.'/../config/saml.php' => config_path('saml.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/saml.php', 'saml'
        );
    }
    
}