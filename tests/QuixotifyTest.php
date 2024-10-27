<?php

use Quixotify\QuixotifyGenerator;
use Quixotify\QuixotifyClient;

class QuixotifyTest extends \PHPUnit\Framework\TestCase
{
    public function testGenerateIpsumText()
    {
        $client = new QuixotifyClient();
        $generator = new QuixotifyGenerator($client);

        $ipsumText = $generator->generate('characters', 100);


        print_r("\n\n\n");
        print_r($ipsumText);
        $this->assertIsString($ipsumText);
        $this->assertGreaterThan(0, strlen($ipsumText));
    }
}