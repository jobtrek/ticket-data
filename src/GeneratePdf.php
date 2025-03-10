<?php

namespace TicketData;

class GeneratePdf
{
    public SetupPdf $setupPdf;

    public function __construct(SetupPdf $setupPdf)
    {
        $this->setupPdf = $setupPdf;
    }

    public function generatePdfAllComputers($arrayOfValue): void
    {
        $this->setupPdf->checkDataMatrix($arrayOfValue);
        $this->setupPdf->setPdf($arrayOfValue);
        $this->setupPdf->Output(__DIR__ . "/ec-pc-labels.pdf", 'F');
    }
}