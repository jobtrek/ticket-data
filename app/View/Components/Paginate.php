<?php

namespace App\View\Components;

use Arr;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Paginate extends Component
{
    public LengthAwarePaginator $paginator;
    public mixed $elementsCollection;
    /**
     * Create a new component instance.
     */
    public function __construct(
        LengthAwarePaginator $items,
    )
    {
        $this->paginator = $items;
        $this->elementsCollection = $items->linkCollection()->toArray();
    }
    
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        $elements = [array_diff_key(Arr::mapWithKeys($this->elementsCollection, static function ($item, $key) {
            return [$key => $item['url']];
        }), [array_key_first($this->elementsCollection) => "xy", array_key_last($this->elementsCollection) =>"xy"])];
        
        return view('components.paginate',
        [
            'paginator' => $this->paginator,
            'elements' => $elements,
        ]
        );
    }
}
