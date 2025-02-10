<?php

use Quixotify\Generator;
use Quixotify\Controller;
use PHPUnit\Framework\TestCase;

class QuixotifyControllerTest extends TestCase
{
    public function testCharacterCount(): void
    {
        for ($i = 0; $i < 2000; $i++) {
            $amount = rand(1, 10000);
            $controller = new Controller();

            $generator = new Generator($controller);
            $ipsumText = $generator->generate(
                'characters', 
                $amount
            );

            $this->assertEquals(
                $amount, 
                mb_strlen($ipsumText, 'UTF-8')
            );
        }
    }
    public function testShortLengthCharacterCount(): void
    {
        for ($i = 0; $i < 2000; $i++) {
            $amount = rand(1, 10);
            $controller = new Controller();

            $generator = new Generator($controller);
            $ipsumText = $generator->generate('characters', $amount);

            $this->assertEquals(
                $amount, 
                mb_strlen($ipsumText, 'UTF-8')
            );
        }
    }

    public function testWordCount(): void
    {
        $i = 0;
        while ($i < 2000) {
            $amount = rand(1, 100);
            $controller = new Controller();
            $generator = new Generator($controller);

            $ipsumText = $generator->generate(
                'words', 
                $amount
            );

            $testWords = explode(' ', $ipsumText);
            $this->assertEquals(
                count($testWords), 
                $amount
            );
            $i++;
        }
    }

    public function testSentenceCount(): void
    {
        $i = 0;
        while ($i < 500) {
            $amount = rand(1, 50);
            $controller = new Controller();
            $generator = new Generator($controller);

            $ipsumText = $generator->generate(
                'sentences', 
                $amount
            );

            $testResult = preg_split(
                '/[\\!\\?\\.]/', 
                trim($ipsumText), 
                -1, 
                PREG_SPLIT_NO_EMPTY
            );

            // getting variation of 1 sentence
            // @TODO: Fix this this.
            $this->assertTrue(
                abs(num: count($testResult) - $amount) < 5
            );
            $i++;
        }
    }
    public function testCharacterCountInSpanish(): void
{
    for ($i = 0; $i < 2000; $i++) {
        $amount = rand(1, 10000);
        $controller = new Controller("Spanish");

        $generator = new Generator($controller);
        $ipsumText = $generator->generate(
            'characters', 
            $amount
        );

        $this->assertEquals(
            $amount, 
            mb_strlen($ipsumText, 'UTF-8')
        );
    }
}
    public function testShortLengthCharacterCountInSpanish(): void
    {
        for ($i = 0; $i < 2000; $i++) {
            $amount = rand(1, 10);
            $controller = new Controller("Spanish");

            $generator = new Generator($controller);
            $ipsumText = $generator->generate(
                'characters', 
                $amount
            );

            $this->assertEquals(
                $amount, 
                mb_strlen($ipsumText, 'UTF-8')
            );
        }
    }

    public function testWordCountInSpanish(): void
    {
        $i = 0;
        while ($i < 2000) {
            $amount = rand(1, 100);
            $controller = new Controller("Spanish");
            $generator = new Generator($controller);

            $ipsumText = $generator->generate('words', $amount);

            $testWords = explode(' ', $ipsumText);
            $this->assertEquals(
                count($testWords), 
                $amount
            );
            $i++;
        }
    }

    public function testSentenceCountInSpanish(): void
    {
        $i = 0;
        while ($i < 500) {
            $amount = rand(1, 50);
            $controller = new Controller("Spanish");
            $generator = new Generator($controller);

            $ipsumText = $generator->generate(
                'sentences', 
                $amount
            );

            $testResult = preg_split(
                '/[\\!\\?\\.]/', 
                trim($ipsumText), 
                -1, 
                PREG_SPLIT_NO_EMPTY
            );

            // getting variation of 1 sentence
            // @TODO: Fix this this.
            $this->assertTrue(
                abs(num: count($testResult) - $amount) < 5
            );
            $i++;
        }
    }
}
