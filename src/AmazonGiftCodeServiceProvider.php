<?php

/**
 * Part of the AmazonGiftCode package.
 * Author: Kashyap Merai <kashyapk62@gmail.com>
 *
 */

namespace kamerk22\AmazonGiftCode;

use Illuminate\Support\ServiceProvider;

class AmazonGiftCodeServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
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
            __DIR__ . '/../config/amazongiftcode.php' => config_path('amazongiftcode.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/../config/amazongiftcode.php', 'amazongiftcode');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Register the service the package provides.
        $this->app->bind(AmazonGiftCode::class, function ($app) {
            return new AmazonGiftCode(
                $app['config']['amazongiftcode']['key'],
                $app['config']['amazongiftcode']['secret'],
                $app['config']['amazongiftcode']['partner'],
                $app['config']['amazongiftcode']['endpoint'],
                $app['config']['amazongiftcode']['currency']
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [AmazonGiftCode::class];
    }
}
