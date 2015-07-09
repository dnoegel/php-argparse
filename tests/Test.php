<?php

use Argparse\Argument\OptionalArgument;
use Argparse\Argument\PositionalArgument;
use Argparse\ValueHandler\ConstantValueHandler;
use Argparse\ValueHandler\MultiValueHandler;
use Argparse\ValueHandler\StoreValueHandler;

class Test extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $parser = new \Argparse\Parser();

        $parser->addArgument('-v', '--verbose')->setValueHandler(new \Argparse\ValueHandler\CountingValueHandler());
        $parser->addArgument('-n')->setConsume(1)->setValueHandler(new StoreValueHandler());
        $parser->addArgument('--colors')->setValueHandler(new ConstantValueHandler(true));
        $parser->addArgument('--filter')->setValueHandler(new StoreValueHandler())->setConsume(1);
        $parser->addArgument('--anotherFilter')->setValueHandler(new StoreValueHandler())->setConsume(1);
        $parser->addArgument('--randomParam')->setValueHandler(new MultiValueHandler())->setConsume(1);
        $parser->addArgument('files')->setValueHandler(new MultiValueHandler())->setConsume(3);

        $result = $parser->parse([
            '/usr/bin/tst', '--colors', '-vvn1',
            '-v', '--filter', 'hallo welt"',
            '--anotherFilter=test',
            'make', 'it', 'work'
        ]);


        $expect = [
            'colors' => true,
            'v' => 3,
            'n' => 1,
            'filter' => 'hallo welt"',
            'anotherFilter' => 'test',
            'files' => [
                'make', 'it', 'work'
            ]
        ];
    }
    public function testSplit()
    {
        $string = '/usr/bin/tst --colors --vvn1 -v --filter \'hallo welt"\' --anotherFilter=test make it work';

        $p = new \Argparse\StringSplitter();
        $result = $p->split($string);

    }
}