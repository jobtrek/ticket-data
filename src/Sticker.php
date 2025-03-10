<?php

namespace TicketData;

use RuntimeException;

readonly class Sticker
{
    private int $width;
    private int $height;
    
    public function __construct(
        int $width= 45,
        int $height = 20,
    )
    {
        if ($height > $width) {
            throw new RuntimeException("The height must be less than the width");
        }
        
        $this->width = $width;
        $this->height = $height;
        
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
    
}