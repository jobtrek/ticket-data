<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class PaginateService 
{

    public function paginate($items): LengthAwarePaginator
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = request()->input('perPage', 20);
        $itemsInstance = $items instanceof Collection ? $items : Collection::make($items);
        $newItemsInstance = $itemsInstance->forPage($page, $perPage);
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
            'perPage' => $perPage,
        ];
        
        return new LengthAwarePaginator($newItemsInstance, $itemsInstance->count(), $perPage, $page, $options);
    }
    

}