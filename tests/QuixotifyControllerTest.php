<?php

use Quixotify\Generator;
use Quixotify\Controller;
use function PHPUnit\Framework\assertEquals;

class QuixotifyControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testGenerateIpsumText()
    {
        $controller = new Controller(new PDO('sqlite:database.db', '', ''));
        $generator = new Generator($controller);

        $ipsumText = $generator->generate('characters', 100);


        print_r("\n\n\n");
        print_r($ipsumText);
        $this->assertIsString($ipsumText);
        $this->assertGreaterThan(0, strlen($ipsumText));
    }
    public function testCharacterCount(): void
    {
        $i = 0;
        while ($i < 5) {
            $amount = rand(1, 10000);
            $controller = new Controller(new PDO('sqlite:database.db', '', ''));
            $generator = new Generator($controller);

            $ipsumText = $generator->generate('characters', $amount);

            print_r($ipsumText);
            $this->assertEquals($amount, strlen($ipsumText));
            $this->assertTrue(abs(strlen($ipsumText) - $amount) <= 10);
            $i++;
        }
    }
    public function testWordCount(): void
    {
        $i = 0;
        while ($i < 5) {
            $amount = rand(1, 100);
            $controller = new Controller(new PDO('sqlite:database.db', '', ''));
            $generator = new Generator($controller);

            $ipsumText = $generator->generate('words', $amount);

            $testWords = explode(' ', $ipsumText);
            $this->assertEquals(count($testWords), $amount);
            $i++;
        }
    }

    public function testSentenceCount(): void
    {

    }
}
