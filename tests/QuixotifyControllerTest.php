<?php

use Quixotify\Generator;
use Quixotify\Controller;
use function PHPUnit\Framework\assertEquals;

class QuixotifyControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testCharacterCount(): void
    {
        for ($i = 0; $i < 2000; $i++) {
            $amount = rand(1, 10000);
            $controller = new Controller(new PDO('sqlite:database.db'));

            $generator = new Generator($controller);
            $ipsumText = $generator->generate('characters', $amount);

            $this->assertEquals($amount, mb_strlen($ipsumText, 'UTF-8'));
        }
    }
    public function testShortLengthCharacterCount(): void
    {
        for ($i = 0; $i < 2000; $i++) {
            $amount = rand(1, 10);
            $controller = new Controller(new PDO('sqlite:database.db'));

            $generator = new Generator($controller);
            $ipsumText = $generator->generate('characters', $amount);

            $this->assertEquals($amount, mb_strlen($ipsumText, 'UTF-8'));
        }
    }

    public function testWordCount(): void
    {
        $i = 0;
        while ($i < 2000) {
            $amount = rand(1, 100);
            $controller = new Controller(new PDO('sqlite:database.db', '', ''));
            $generator = new Generator($controller);

            $ipsumText = $generator->generate('words', $amount);

            var_dump('amount ',$amount);
            $testWords = explode(' ', $ipsumText);
            $this->assertEquals(count($testWords), $amount);
            $i++;
        }
    }

    public function testSentenceCount(): void
    {
        $this->markTestSkipped("skip sentence count");
        $i = 0;
        while ($i < 500) {
            $amount = rand(1, 100);
            $controller = new Controller(new PDO('sqlite:database.db', '', ''));
            $generator = new Generator($controller);

            $ipsumText = $generator->generate('sentences', $amount);

            $testResult = preg_split('/[\\!\\?\\.]/', trim($ipsumText), -1, PREG_SPLIT_NO_EMPTY);
            $this->assertEquals(count($testResult), $amount);
            $i++;
        }
    }
}
