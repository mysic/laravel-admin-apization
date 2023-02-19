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

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'laravel-admin-apization');
        }

        if ($this->app->runningInConsole()) {
            if($assets = $extension->assets()) {
                $this->publishes(
                    [$assets => public_path('vendor/mysic/laravel-admin-apization')],
                    'laravel-admin-apization'
                );
            }

            $this->publishes([__DIR__.'/../config' => config_path()], 'laravel-admin-apization');
        }

        $this->app->booted(function () {
            Bootstrap::boot();
        });
    }
}
