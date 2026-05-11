<?php

namespace SchoolAid\Powertranz;

use Illuminate\Support\ServiceProvider;

class PowertranzServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $config = __DIR__.'/../config/powertranz.php';
        $this->mergeConfigFrom($config, 'powertranz');

        $this->publishes([
            $config => config_path('powertranz.php'),
        ]);
    }
}
