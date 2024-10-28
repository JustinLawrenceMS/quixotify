<?php

use Quixotify\Generator;
use Quixotify\Controller;

class Test extends \PHPUnit\Framework\TestCase
{
    public function testGenerateIpsumText()
    {
        $controller = new Controller(new PDO('sqlite:database.db', '', ''));
        $generator = new Generator($controller);

        $ipsumText = $generator->generate('characters', 100);


        print_r("\n\n\n");
        print_r($ipsumText);
        $this->assertIsString($ipsumText['ipsum_text']);
        $this->assertGreaterThan(0, strlen($ipsumText['ipsum_text']));
    }
}
