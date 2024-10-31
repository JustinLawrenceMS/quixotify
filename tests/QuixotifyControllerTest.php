<?php

use Quixotify\Generator;
use Quixotify\Controller;
use function PHPUnit\Framework\assertEquals;

class QuixotifyControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testCharacterCount(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $amount = rand(1, 10000);
            $controller = new Controller(new PDO('sqlite:database.db'));

            $generator = new Generator($controller);
            $ipsumText = $generator->generate('characters', $amount);

            // Assertion check
            $this->assertEquals($amount, mb_strlen($ipsumText, 'UTF-8'));
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
        $i = 0;
        while ($i < 5) {
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
