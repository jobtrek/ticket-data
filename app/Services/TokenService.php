<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TokenService
{
    private ?string $sessionToken = null;

    /**
     * @throws ConnectionException
     */
    public function getSessionToken(): string
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'user_token '. config('services.glpi.user_token'),
            'App-Token' => config('services.glpi.app_token'),
        ])->get(config('services.glpi.url') . 'initSession');
        
        return $response->json('session_token');
    }

    /**
     * @throws ConnectionException
     */
    public function setSessionToken(): void
    {
        $this->sessionToken = $this->getSessionToken();
    }

    /**
     * @throws ConnectionException
     */
    public function cacheSessionToken(): void
    {
        
        if (!$this->sessionToken){
            $this->setSessionToken();
        }
        
        Cache::remember('session_token', now()->addDay(), function () {
            return $this->sessionToken;
        });
        
    }

    /**
     * @throws ConnectionException
     */
    public function getCacheSessionToken()
    {

        if (Cache::missing('session_token')) {
            $this->cacheSessionToken();
        }

        return Cache::get('session_token');
        
    }

    /**
     * @throws ConnectionException
     */
    public function flushCacheSession(): RedirectResponse
    {
        
        Cache::flush();
        $this->cacheSessionToken();
        return redirect('/');
        
    }
    
}