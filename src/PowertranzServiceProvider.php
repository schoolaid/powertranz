<?php
namespace Said\Powertranz;

use Illuminate\Support\ServiceProvider;

class PowertranzServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/powertranz.php' => config_path('powertranz.php'),
        ]);
    }
}
