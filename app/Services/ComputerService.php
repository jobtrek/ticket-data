<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ComputerService
{
    public function __construct(
        protected PaginateService $paginateService
    ){}


    /**
     * @throws ConnectionException
     */
    public function getComputers(?string $range = null): array
    {
        if ($range) {
            return Http::glpi()->get('Computer/?expand_dropdowns=true&range=' . $range)->json();
        }
        
        return Http::glpi()->get('Computer/?expand_dropdowns=true&range=0-160')->json();
    }

    public function cachedComputers(): array
    {
        return Cache::remember('computers', now()->addDay(), function () {
            return $this->getComputers();
        });
    }

/*    public function oui()
    {
        $selectNumber = $request->input('number', 15);

        $computers = Cache::remember('computers', now()->addDay(), function () {
            return $this->computerService->getComputers();
        });

        return view('computers.computers', compact('selectNumber', 'computers'));
    }*/

    /**
     * @throws ConnectionException
     */
    public function searchOptions(): array
    {
        
        return Http::glpi()->get('listSearchOptions/Computer')->json();
        
    }
    
}