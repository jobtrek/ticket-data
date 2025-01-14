<?php

namespace TicketData;

use TCPDF;

class SetupPdf extends TCPDF
{
    public int $top_margin = 5;
    public int $left_margin = 0;
    public int $sticker_width = 70;
    public float $sticker_height = 19.9;
    public int $lines = 17;
    public  $columns = 3;
    public int $sticker_count = 1;
    public int $current_sticker = 0;
    public int $number_of_stickers_per_type = 1;

    public function stickersPerPages(): float|int
    {
        return $this->lines * $this->columns;
    }
    
    public function totalOfPages( array $apprentices): float
    {
        return ceil(($this->number_of_stickers_per_type * count($apprentices)) / $this->stickersPerPages());
    }
}