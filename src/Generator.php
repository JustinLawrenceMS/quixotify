<?php

namespace Quixotify;

use Quixotify\Controller;

class Generator
{
    private $client;

    public function __construct(Controller $client)
    {
        $this->client = $client;
    }

    public function generate($type, $amount): array
    {
        return $this->client->generateIpsumText($type, $amount);
    }
}