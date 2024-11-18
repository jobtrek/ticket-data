<?php

namespace TicketData;

use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;

class GetSessionToken
{
    private $config;
    private $client;

    private $sessionToken;
    private $sessionInitializedClient;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = HttpClient::create(
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'App-Token' => $this->config->getAppToken(),
                ]
            ]
        );
    }

    public function fetchSessionTokenGlpi($fullSession = false): array
    {
        $clientWithUserToken = $this->client->withOptions(
            [
                'headers' => [
                    'Authorization' => 'user_token ' . $this->config->getUserToken(),
                ]
            ]
        );
        if ($fullSession) {
            try {
                $response = $clientWithUserToken->request(
                    'GET',
                    'https://glpi.jt-lab.ch/apirest.php/initSession?get_full_session=true',
                );

                $data = $response->toArray();
                return $data;
            } catch (ClientException $e) {
                var_dump($e->getMessage(), $e->getResponse()->getContent(false));
                throw $e;
            }
        } else {
            try {
                $response = $clientWithUserToken->request(
                    'GET',
                    'https://glpi.jt-lab.ch/apirest.php/initSession',
                );
                $data = $response->toArray();
                return $data;
            } catch (ClientException $e) {
                var_dump($e->getMessage(), $e->getResponse()->getContent(false));
                throw $e;
            }
        }
    }

    public function setTokenSession()
    {
        $this->sessionToken = $this->fetchSessionTokenGlpi()['session_token'];
    }

    public function getSessionInitializedClient()
    {
        // Check if session is already set
        if ($this->sessionToken) {
            $this->sessionInitializedClient = $this->client->withOptions(
                [
                    'headers' => [
                        'Session-Token' => $this->sessionToken,
                    ]
                ]
            );
            return $this->sessionInitializedClient;
        } // if not, initialize it (with fetchSessionTokenGlpi())
        else {
            $this->setTokenSession();
            $this->sessionInitializedClient = $this->client->withOptions(
                [
                    'headers' => [
                        'Session-Token' => $this->sessionToken,
                    ]
                ]
            );
            return $this->sessionInitializedClient;
        }
    }

    public function request(string $string, string $string1)
    {
        $this->getSessionInitializedClient();
        // then make the api call
        try {
            $response = $this->sessionInitializedClient->request(
            $string,
            $string1
        );
        $data = $response->toArray();
        return $data;
        } catch (ClientException $e) {
            var_dump($e->getMessage(), $e->getResponse()->getContent(false));
            throw $e;
        }
    }


}