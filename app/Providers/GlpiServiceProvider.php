<?php

namespace App\Providers;

use App\Services\GlpiServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class GlpiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GlpiServices::class, function (Application $app) {
            return new GlpiServices();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Http::macro('glpi', function () {
            
            return Http::withHeaders([
                
                'Content-Type' => 'application/json',
                'Session-Token' => app(GlpiServices::class)->getSessionToken(),
                'App-Token' => config('services.glpi.app_token')
                
            ])->baseUrl('https://glpi.in.jt-lab.ch/apirest.php/');
            
        });
    }
}
