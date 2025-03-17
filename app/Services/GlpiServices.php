<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class GlpiServices
{
    /**
     * @throws ConnectionException
     */
    public function getSessionToken(): string
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'user_token '. config('services.glpi.user_token'),
            'App-Token' => config('services.glpi.app_token')])->get(config('services.glpi.url').'initSession');
        
        return $response->json('session_token');
    }
    
    /**
     * @throws ConnectionException
     */
    public function getComputers(): array
    {
        return Http::glpi()->get('Computer')->json();
    }
}