<?php

namespace Mysic\LaravelAdminApization;

use Illuminate\Support\ServiceProvider;

class LaravelAdminApizationServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(LaravelAdminApization $extension)
    {
        if (! LaravelAdminApization::boot()) {
            return ;
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/config' => config_path()], 'laravel-admin-apization');
        }
    }
}
