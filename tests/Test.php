<?php

use Argparse\Argument\OptionalArgument;
use Argparse\Argument\PositionalArgument;
use Argparse\Result\Result;
use Argparse\ValueHandler\ConstantValueHandler;
use Argparse\ValueHandler\MultiValueHandler;
use Argparse\ValueHandler\StoreValueHandler;

class Test extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $expect = [
            '-v' => 3,
            '--verbose' => 3,
            '-n' => 1,
            '--colors' => true,
            '--filter' => 'hallo welt"',
            '--anotherFilter' => 'test',
            '--randomParam' => [],
            'files' => [
                'foo', 'bar', 'baz'
            ]

        ];

        $parser = new \Argparse\Parser();

        $parser->addArgument('-v', '--verbose')->setValueHandler(new \Argparse\ValueHandler\CountingValueHandler());
        $parser->addArgument('-n')->setConsume(1)->setValueHandler(new StoreValueHandler());
        $parser->addArgument('--colors')->setValueHandler(new ConstantValueHandler(true));
        $parser->addArgument('--filter')->setValueHandler(new StoreValueHandler())->setConsume(1);
        $parser->addArgument('--anotherFilter')->setValueHandler(new StoreValueHandler())->setConsume(1);
        $parser->addArgument('--randomParam')->setValueHandler(new MultiValueHandler())->setConsume(1);
        $parser->addArgument('files')->setValueHandler(new MultiValueHandler())->setConsume(3);
        $parser->setHandler(new TestHandler($this, $expect));


        $result = $parser->parse([
            '/usr/bin/tst', '--colors', '-vvn1',
            '-v', '--filter', 'hallo welt"',
            '--anotherFilter=test',
            'foo', 'bar', 'baz'
        ]);

        foreach ($expect as $key => $value) {
            $this->assertEquals($value, $result->get($key));
        }

    }
}

class TestHandler implements Argparse\Handler\HandlerInterface
{
    /**
     * @var PHPUnit_Framework_TestCase
     */
    private $testCase;
    /**
     * @var
     */
    private $expect;

    public function __construct(PHPUnit_Framework_TestCase $testCase, $expect) {

        $this->testCase = $testCase;
        $this->expect = $expect;
    }

    public function handle(Result $result)
    {
        foreach ($this->expect as $key => $value) {
            $this->testCase->assertEquals($value, $result->get($key));
        }
    }

}