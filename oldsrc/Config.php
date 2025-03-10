<?php

namespace TicketData;

use Dotenv\Dotenv;

class Config
{
    public mixed $userToken;
    public mixed $appToken;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__. '/../');
        $dotenv->load();
        $this->userToken = $_ENV['USER_TOKEN'];
        $this->appToken = $_ENV['APP_TOKEN'];
    }

    public function getUserToken(): string
    {
        return $this->userToken;
    }

    public function getAppToken(): string
    {
        return $this->appToken;
    }



}