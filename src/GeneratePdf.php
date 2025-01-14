<?php

namespace TicketData;

class GeneratePdf
{
    
    public RequestGlpi $requestGlpi;

    public function __construct(RequestGlpi $requestGlpi)
    {
        $this->requestGlpi = $requestGlpi;
    }
    
    public function sortValueComputers() : array
    {
        $computers = $this->requestGlpi->fetchAllComputer();

        return array_map(function ($array) {
            $realNameContact = explode(".", $array['contact']);
            return [
                'name' => $array['name'],
                'contact' => ucfirst($realNameContact[0]),
                'uuid' => $array['uuid'],
            ];
        }, $computers);
    }

    public function handle(): void
    {
        $apprentices = $this->sortValueComputers();

        $tcPdf = new SetupPdf('P', 'mm', 'A4', true, 'UTF-8');
        $tcPdf->setPrintHeader(false);
        $tcPdf->setPrintFooter(false);
        $tcPdf->setMargins(0, 0, 0);
        $tcPdf->setAutoPageBreak(false);
        $tcPdf->SetFont('helvetica', 'B', 10);

        for ($page = 0; $page < $tcPdf->totalOfPages($apprentices); $page++) {
            $tcPdf->AddPage();
            $this->addStickersToPage($tcPdf, $apprentices);

        }
        $tcPdf->Output(__DIR__ . "/ec-pc-labels.pdf", 'F');
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
    
    private function addStickersToPage(SetupPdf $tcPdf, array $apprentices): void
    {
        for ($line = 0; $line < $tcPdf->lines; $line++) {
            $current_line_offset = $tcPdf->top_margin + ($line * $tcPdf->sticker_height);

            for ($column = 0; $column < $tcPdf->columns; $column++) {
                $current_column_offset = $tcPdf->left_margin + ($column * $tcPdf->sticker_width);

                if ($tcPdf->sticker_count > $tcPdf->number_of_stickers_per_type) {
                    $tcPdf->current_sticker++;
                    if ($tcPdf->current_sticker >= count($apprentices)) {
                        break;
                    }
                    $tcPdf->sticker_count = 1;
                }
                $this->addSticker($tcPdf, $apprentices[$tcPdf->current_sticker], $current_column_offset, $current_line_offset);
                $tcPdf->sticker_count++;
            }
        }
    }
}