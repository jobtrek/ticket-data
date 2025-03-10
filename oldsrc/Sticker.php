<?php

namespace TicketData;

class Sticker
{
    private int $width;
    private float $height;
    private mixed $content;
    const int WIDTH =20;
    const float HEIGHT = 20;
    

    
    public function __construct(
        int $width = self::WIDTH,
        float $height = self::HEIGHT,
    )
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function generateSticker($x, $y, $data): void {
        $this->setWidth($x);
        $this->setHeight($y);
        $this->setContent($data);
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function setHeight(float $height): void
    {
        $this->height = $height;
    }
    
    public function getContent(): mixed
    {
        return $this->content;
    }
    
    public function setContent(mixed $content): void
    {
        $this->content = $content;
    }
    
}