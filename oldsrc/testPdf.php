<?php

use TicketData\SetupPdf;
use TicketData\Sticker;

require_once __DIR__.'/../vendor/autoload.php';

$apprentices = [['inventory' => 'JT-24-11-01', 'user' => 'Bryan'],
    ['inventory' => 'JT-24-11-02', 'user' => 'Léa'],
    ['inventory' => 'JT-24-11-03', 'user' => 'Roman'],
    ['inventory' => 'JT-24-11-04', 'user' => 'Maryam'],
    ['inventory' => 'JT-24-11-05', 'user' => 'Dmytro'],
    ['inventory' => 'JT-24-11-06', 'user' => 'Haki'],
    ['inventory' => 'JT-24-11-07', 'user' => 'Colin'], ];
$nouveau = [
    ['inventory' => 'JT-23-09-24'],
    ['inventory' => 'JT-23-09-24'],
    ['inventory' => 'JT-22-01-02'],
    ['inventory' => 'JT-22-01-02'],
    ['inventory' => 'JT-22-01-19'],
    ['inventory' => 'JT-22-01-19'],
    ['inventory' => 'JT-22-01-18'],
    ['inventory' => 'JT-22-01-18'],
    ['inventory' => 'JT-22-01-09'],
    ['inventory' => 'JT-22-01-09'],
    ['inventory' => 'JT-22-01-26'],
    ['inventory' => 'JT-22-01-26'],
    ['inventory' => 'JT-22-01-25'],
    ['inventory' => 'JT-22-01-25'],
    ['inventory' => 'JT-22-01-21'],
    ['inventory' => 'JT-22-01-21'],
    ['inventory' => 'JT-22-01-17'],
    ['inventory' => 'JT-22-01-17'],
    ['inventory' => 'JT-22-01-06'],
    ['inventory' => 'JT-22-01-06'],
    ['inventory' => 'JT-22-01-07'],
    ['inventory' => 'JT-22-01-07'],
    ['inventory' => 'JT-22-01-08'],
    ['inventory' => 'JT-22-01-08'],
    ['inventory' => 'JT-22-01-24'],
    ['inventory' => 'JT-22-01-24'],
    ];

$sticker = new Sticker;
$tcpdf = new SetupPdf;
$tcpdf->setPrintHeader(false);
$tcpdf->setPrintFooter(false);
$tcpdf->setAutoPageBreak(true, 0);
$tcpdf->SetFont('helvetica', 'B', 10);
$tcpdf->AddPage();
$position = $tcpdf->calculate_position($sticker->getWidth(), $sticker->getHeight());
$tcpdf->generateDataMatrix($position);
// $setupPdf->generateManyDatamatrix(7);
// $setupPdf->generateDatamatrixWithText($apprentices);
$tcpdf->Output(__DIR__.'/test1.pdf', 'F');
