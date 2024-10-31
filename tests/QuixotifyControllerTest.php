<?php

use Quixotify\Generator;
use Quixotify\Controller;
use function PHPUnit\Framework\assertEquals;

class QuixotifyControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testGenerateIpsumText()
    {
        $this->markTestSkipped();
        $controller = new Controller(new PDO('sqlite:database.db', '', ''));
        $generator = new Generator($controller);

        $ipsumText = $generator->generate('characters', 100);


        $this->assertIsString($ipsumText);
        $this->assertGreaterThan(0, mb_strlen($ipsumText));
    }
    public function testCharacterCount(): void
    {
        $this->markTestSkipped();
        $i = 0;
        while ($i < 5) {
            $amount = 100;
            $controller = new Controller(new PDO('sqlite:database.db', '', ''));
            $generator = new Generator($controller);

            $ipsumText = $generator->generate('characters', $amount);

            $this->assertEquals($amount, mb_strlen($ipsumText, 'UTF-8'));
            $this->assertTrue(abs(mb_strlen($ipsumText, 'UTF-8') - $amount) <= 10);
            $i++;
        }
    }
    public function testWordCount(): void
    {
        $i = 0;
        while ($i < 5) {
            $amount = 15;
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
