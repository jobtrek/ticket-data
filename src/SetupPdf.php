<?php

namespace TicketData;

use PhpParser\Node\Expr\Cast\Object_;
use TCPDF;

class SetupPdf extends TCPDF
{
    public AdaptRequest $adaptRequest;
    public int $top_margin = 5;
    public int $left_margin = 0;
    public int $sticker_width = 70;
    public float $sticker_height = 19.9;
    public int $lines = 17;
    public  $columns = 3;
    public int $sticker_count = 1;
    public int $current_sticker = 0;
    public int $number_of_stickers_per_type = 1;

    public function __construct(AdaptRequest $adaptRequest)
    {
        parent::__construct();
        $this->adaptRequest = $adaptRequest;
    }


    public function stickersPerPages(): float|int
    {
        return $this->lines * $this->columns;
    }
    
    public function totalOfPages( array $apprentices): float
    {
        return ceil(($this->number_of_stickers_per_type * count($apprentices)) / $this->stickersPerPages());
    }
    public function setPdf(SetupPdf $tcpdf): SetupPdf
    {
        $apprentices = $this->adaptRequest->sortValueComputers();
        $this->setPrintHeader(false);
        $this->setPrintFooter(false);
        $this->setMargins(0, 0, 0);
        $this->setAutoPageBreak(false);
        $this->SetFont('helvetica', 'B', 10);

        for ($page = 0; $page < $this->totalOfPages($apprentices); $page++) {
            $this->AddPage();
            $this->addStickersToPage($tcpdf, $apprentices);

        }
        return $this;
    }

    public function addSticker(SetupPdf $tcpdf, array $apprentices, float $current_column_offset, float $current_line_offset): void
    {
        $tcpdf->write2DBarcode(
            $apprentices["uuid"],
            'DATAMATRIX',
            $current_column_offset + 6,
            $current_line_offset + 2,
            12,
            12,
            [
                'border' => 0,
                'vpadding' => 0,
                'hpadding' => 0,
                'fgcolor' => [0, 0, 0],
                'bgcolor' => false,
                'module_width' => 1,
                'module_height' => 1,
            ],
            'N'
        );
        $tcpdf->Text($current_column_offset + 20, $current_line_offset + 2, $apprentices["name"]);
        $tcpdf->Text($current_column_offset + 20, $current_line_offset + 8, $apprentices["contact"]);
    }

    private function addStickersToPage(SetupPdf $tcpdf, array $apprentices): void
    {
        for ($line = 0; $line < $this->lines; $line++) {
            $current_line_offset = $this->top_margin + ($line * $this->sticker_height);

            for ($column = 0; $column < $this->columns; $column++) {
                $current_column_offset = $this->left_margin + ($column * $this->sticker_width);

                if ($this->sticker_count > $this->number_of_stickers_per_type) {
                    $this->current_sticker++;
                    if ($this->current_sticker >= count($apprentices)) {
                        break;
                    }
                    $this->sticker_count = 1;
                }
                $this->addSticker($tcpdf, $apprentices[$this->current_sticker], $current_column_offset, $current_line_offset);
                $this->sticker_count++;
            }
        }
    }
}