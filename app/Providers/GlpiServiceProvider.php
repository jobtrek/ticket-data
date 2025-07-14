<?php

namespace App\Providers;

use App\Services\TokenService;
use Illuminate\Foundation\Application;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class GlpiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TokenService::class, function () {
            return new TokenService();
        });
    }

    /**
     * Bootstrap services.
     * @throws ConnectionException
     */
    public function boot(TokenService $tokenService): void
    {
        $tokenService->cacheSessionToken();
        
        Http::macro('glpi', function () {
            
            return Http::withHeaders([
                'Content-Type' => 'application/json',
                'Session-Token' => Cache::get('session_token'),
                'App-Token' => config('services.glpi.app_token'),
            ])->baseUrl(config('services.glpi.url'));
            
    });
        
    }
}
