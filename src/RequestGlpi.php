<?php

namespace TicketData;


class RequestGlpi
{
    public GetSessionToken $session;

    public function __construct(GetSessionToken $getSessionToken)
    {
        $this->session = $getSessionToken;
    }

    public function fetchComputer($id): array
    {
        return $this->session->request(
            'GET',
            'https://glpi.in.jt-lab.ch/apirest.php/Computer/' . $id,
        );
    }

    public function fetchAllComputer($range = 15): array
    {
        return $this->session->request(
            'GET',
            'https://glpi.in.jt-lab.ch/apirest.php/Computer/?range=0-' . $range,
        );
    }
}