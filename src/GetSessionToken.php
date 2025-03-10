<?php

namespace TicketData;

use Exception;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetSessionToken
{
    private Config $config;
    private HttpClientInterface $client;

    private string $sessionToken;

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

    public function fetchSessionTokenGlpi(bool $fullSession = false): array
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
                    'https://glpi.in.jt-lab.ch/apirest.php/initSession?get_full_session=true',
                );
                return $response->toArray();
            } catch (ClientException $e) {
                throw $e;
            }
        } else {
            try {
                $response = $clientWithUserToken->request(
                    'GET',
                    'https://glpi.in.jt-lab.ch/apirest.php/initSession',
                );
                return $response->toArray();
            } catch (ClientException $e) {
                throw $e;
            }
        }
    }

    public function setTokenSession()
    {
        $this->sessionToken = $this->fetchSessionTokenGlpi()['session_token'];
    }

    public function getSessionInitializedClient(): HttpClientInterface
    {
        // Check if session is already set
        if (!$this->sessionToken) {
            $this->setTokenSession();
        } // if not, initialize it (with fetchSessionTokenGlpi())
        return $this->client->withOptions(
            [
                'headers' => [
                    'Session-Token' => $this->sessionToken,
                ]
            ]
        );
    }

    public function executeRequest(string $method, string $url): array
    {
        return $this->getSessionInitializedClient()->request(
            $method,
            $url
        )->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function request(string $method, string $url): array
    {
        for ($i = 0; $i < 3; $i++) {
            try {
                return $this->executeRequest($method, $url);
            } catch (ClientException $e) {
                if ($e->getResponse()->getStatusCode() === 401) {
                    $this->setTokenSession();
                } else {
                    throw $e;
                }
            }
        }
        throw new Exception('Too many retries');
    }
}