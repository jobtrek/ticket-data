<?php

namespace TicketData;


class RequestGlpi
{
    public $session;

    public function __construct(GetSessionToken $getSessionToken)
    {
        $this->session = $getSessionToken;
    }

    public function fetchComputer($id): array
    {
        return $this->session->request(
            'GET',
            'https://glpi.jt-lab.ch/apirest.php/Computer/' . $id,
        );
    }

    public function fetchAllComputer(): array
    {
        return $this->session->request(
            'GET',
            'https://glpi.jt-lab.ch/apirest.php/Computer',
        );
    }
}