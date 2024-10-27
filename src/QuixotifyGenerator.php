<?php

namespace Quixotify;

use Quixotify\QuixotifyClient;

class QuixotifyGenerator
{
    private $client;

    public function __construct(QuixotifyClient $client)
    {
        $this->client = $client;
    }

    public function generate($type, $amount)
    {
        return $this->client->getIpsumText($type, $amount);
    }
}