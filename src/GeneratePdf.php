<?php

namespace TicketData;

class GeneratePdf
{
    public SetupPdf $setupPdf;

    public function __construct(SetupPdf $setupPdf)
    {
        $this->setupPdf = $setupPdf;
    }

    public function generatePdfAllComputers(): void
    {
        $this->setupPdf->setPdf($this->setupPdf);
        $this->setupPdf->Output(__DIR__ . "/ec-pc-labels.pdf", 'F');
    }
}