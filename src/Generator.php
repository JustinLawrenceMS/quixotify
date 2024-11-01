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

    public function generate($type, $amount): string
    {
        return $this->client->generateIpsumText($type, $amount);
    }
}
