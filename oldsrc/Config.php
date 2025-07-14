<?php

namespace TicketData;

use Dotenv\Dotenv;

class Config
{
    public mixed $userToken {
        get {
            return $this->userToken;
        }
    }
    public mixed $appToken {
        get {
            return $this->appToken;
        }
    }

    public function __construct()
    {
        $this->userToken = config('services.glpi.user_token');
        $this->appToken = config('services.glpi.app_token');
    }


}