<?php
require __DIR__ . '/../vendor/autoload.php';

use TicketData\AdaptRequest;
use TicketData\Config;
use TicketData\GeneratePdf;
use TicketData\GetSessionToken;
use TicketData\RequestGlpi;
use TicketData\SetupPdf;
/**["uuid" => "dd87b324-1263-4aba-b917-4b4dad3e028f", "inventory" => "JT-24-11-01", "user" => "Bryan"],
["uuid" => "63f13bd2-ce7b-425d-aaa1-0db313121627", "inventory" => "JT-24-11-02", "user" => "Léa"],
["uuid" => "d8255f80-2513-46fe-a6eb-bf67731835d2", "inventory" => "JT-24-11-03", "user" => "Roman"],
["uuid" => "6e75b490-2872-4440-bf45-847b8dfbbdc1", "inventory" => "JT-24-11-04", "user" => "Maryam"],
["uuid" => "5471608d-3b4a-4476-a109-56e28831f89d", "inventory" => "JT-24-11-05", "user" => "Dmytro"],
["uuid" => "0050ba83-f672-42d9-9709-ffa86904df94", "inventory" => "JT-24-11-06", "user" => "Haki"],
["uuid" => "65f5040b-090c-4e76-9dc6-915edca4f0c3", "inventory" => "JT-24-11-07", "user" => "Colin"],*/
$apprentices = [
            ["inventory" => "JT-24-11-10", "user" => "Solyiana"],
            ["inventory" => "JT-24-11-11", "user" => "Sara"],
            ["inventory" => "JT-24-11-12", "user" => "Samira"],
            ["inventory" => "JT-24-11-13", "user" => "Semhar G."],
            ["inventory" => "JT-24-11-14", "user" => "Semhar T."],
            ["inventory" => "JT-24-11-15", "user" => "Elvire"],
            ["inventory" => "JT-24-11-16", "user" => "Lynda"],
            ["inventory" => "JT-24-11-17", "user" => "Strella"],
            ["inventory" => "JT-24-11-18", "user" => "Soraia"],
            ["inventory" => "JT-24-11-19", "user" => "Isabel"],
            ["inventory" => "JT-24-11-20", "user" => "Karolina"],
            ["inventory" => "JT-24-11-21", "user" => "Lola"],
        ];
$config = new Config();
$session = new GetSessionToken($config);
$requestGlpi = new RequestGlpi($session);
$adaptRequest = new AdaptRequest($requestGlpi);
$setupPdf = new SetupPdf();
$generate = new GeneratePdf($setupPdf);
$generate->generatePdfAllComputers($apprentices);