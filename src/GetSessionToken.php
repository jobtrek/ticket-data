<?php

namespace TicketData;

use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;

class GetSessionToken
{
    private $config;
    private $client;

    private $sessionToken;

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
        }
        else {
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

    public function request(string $string, string $string1)
    {
        // $client = $this->getSessionInitializedClient();
        // Check if session is already set
        if (isset($this->sessionToken)) {
            $this->client->withOptions(
                    [
                        'headers' => [
                            'session_token' => $this->sessionToken,
                        ]
                    ]
                );
        }
        // if not, initialize it (with fetchSessionTokenGlpi())
        else {
            $this->setTokenSession();
        }
        // then make the api call
        $response = $this->client->request(
            $string,
            $string1
        );
        return $response;
    }


}