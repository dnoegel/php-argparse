<?php

use Dnoegel\Phargparse\Result;
use Dnoegel\Phargparse\ValueHandler\ConstantValueHandler;
use Dnoegel\Phargparse\ValueHandler\CountingValueHandler;
use Dnoegel\Phargparse\ValueHandler\MultiValueHandler;
use Dnoegel\Phargparse\ValueHandler\StoreValueHandler;

class Test extends PHPUnit_Framework_TestCase
{
    public function testSubParser()
    {
        $parser = new \Dnoegel\Phargparse\Argparse();
        $parser->addArgument('-v')->setValueHandler(new CountingValueHandler());

        $result = $parser->parse([
            '/usr/bin/tst', '-vvv',
        ]);

        $this->assertEquals(3, $result->get('-v'));

        $parser->addSubParser("clone")->addArgument('v')->setConsume(3)->setValueHandler(new MultiValueHandler());

        $result = $parser->parse([
            '/usr/bin/tst', 'clone', 1, 2, 3
        ]);
        $this->assertEquals(3, count($result->get('v')));
    }

    public function testParser()
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

        $parser = new \Dnoegel\Phargparse\Argparse();

        $parser->addArgument('-v', '--verbose')->setValueHandler(new CountingValueHandler());
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

class TestHandler implements Dnoegel\Phargparse\Handler\HandlerInterface
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

    public function handle(Result\Result $result)
    {
        foreach ($this->expect as $key => $value) {
            $this->testCase->assertEquals($value, $result->get($key));
        }
    }

}