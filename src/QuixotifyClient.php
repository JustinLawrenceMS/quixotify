<?php

namespace Quixotify;

use GuzzleHttp\Client;

class QuixotifyClient
{
    private $apiUrl;
    private $httpClient;

    public function __construct($apiUrl = 'http://soothsayer-api.com/api/v1/donquixote')
    {
        $this->apiUrl = $apiUrl;
        $this->httpClient = new Client();
    }

    public function getIpsumText($type, $amount)
    {
        $response = $this->httpClient->get($this->apiUrl .
            '/' .
            $type .
            '?' .
            $type .
            '=' .
            $amount
        );

        return json_decode($response->getBody()->getContents(), true)['ipsum_text'];
    }
}