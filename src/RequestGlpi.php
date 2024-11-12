<?php

namespace TicketData;

use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;


class RequestGlpi
{
    private $sessionToken;

    public function __construct(GetSessionToken $getSessionToken)
    {
        $this->sessionToken = $getSessionToken;
    }
    public function fetchComputer (): array
    {
        try {
            $response = $this->sessionToken->request(
            'GET',
            'https://glpi.jt-lab.ch/apirest.php/Computer');

        $data = $response->toArray();
        return $data;
            } catch (ClientException $e) {
                var_dump($e->getMessage(), $e->getResponse()->getContent(false));
                throw $e;
            }
    }
}