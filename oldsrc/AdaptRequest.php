<?php

namespace TicketData;

class AdaptRequest
{
    public RequestGlpi $requestGlpi;

    public function __construct(RequestGlpi $requestGlpi)
    {
        $this->requestGlpi = $requestGlpi;
    }

    public function sortValueComputers($array) : array
    {
        
        return array_map(function ($array) {
            $realNameContact = explode(".", $array['contact']);
            return [
                'name' => $array['name'],
                'contact' => ucfirst($realNameContact[0]),
                'uuid' => $array['uuid'],
            ];
        }, $array);
    }

}