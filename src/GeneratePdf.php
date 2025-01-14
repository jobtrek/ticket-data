<?php

namespace TicketData;

use TCPDF;

class GeneratePdf
{


    public RequestGlpi $requestGlpi;

    public function __construct(RequestGlpi $requestGlpi)
    {
        $this->requestGlpi = $requestGlpi;
    }

    public function handle(): void
    {
        
        $computers = $this->requestGlpi->fetchAllComputer();
        
        $apprentices = array_map(function ($array) {
            $realNameContact = explode(".", $array['contact']);
            return [
                'name' => $array['name'],
                'contact' => ucfirst($realNameContact[0]),
                'uuid' => $array['uuid'],
            ];
        }, $computers);
        
        $top_margin = 5;
        $left_margin = 0;

        $sticker_width = 70;
        $sticker_height = 19.9;

        $lines = 17;
        $columns = 3;
        $stickers_per_page = $lines * $columns;

        $sticker_count = 1;
        $current_sticker = 0;

        $number_of_stickers_per_type = 2;

        $total_of_pages = ceil(($number_of_stickers_per_type * count($apprentices)) / $stickers_per_page);

        //try {
        $tcPdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
        $tcPdf->setPrintHeader(false);
        $tcPdf->setPrintFooter(false);
        $tcPdf->setMargins(0, 0, 0);
        $tcPdf->setAutoPageBreak(false, 0);
        $tcPdf->SetFont('helvetica', 'B', 10);

        for ($page = 0; $page < $total_of_pages; $page++) {

            $tcPdf->AddPage();

            for ($line = 0; $line < $lines; $line++) {
                $current_line_offset = $top_margin + ($line * $sticker_height);

                for ($column = 0; $column < $columns; $column++) {
                    $current_column_offset = $left_margin + ($column * $sticker_width);

                    if ($sticker_count > $number_of_stickers_per_type) {
                        $current_sticker++;
                        if ($current_sticker >= count($apprentices)) {
                            break;
                        }
                        $sticker_count = 1;
                    }

                    $tcPdf->write2DBarcode(
                        $apprentices[$current_sticker]["uuid"],
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
                    $tcPdf->Text($current_column_offset + 20, $current_line_offset + 2, $apprentices[$current_sticker]["name"]);
                    $tcPdf->Text($current_column_offset + 20, $current_line_offset + 8, $apprentices[$current_sticker]["contact"]);

                    $sticker_count++;
                }
            }

        }
         $tcPdf->Output(__DIR__ . "/ec-pc-labels.pdf", 'F');
    }

}