<?php

class DescriptionTest extends PHPUnit_Framework_TestCase
{
    public function testDescription()
    {
        $parser = new \Dnoegel\PhpArgParse\Argparse('git', 'A simple version control system');
        $parser->addArgument('--something', '-s')->setDescription('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.');
        $parser->addArgument('--somethingElse', '-e')->setDescription('Situs vilate in isset abernit');

        $output = new \Dnoegel\PhpArgParse\OutputWriter\InMemoryOutputWriter();
        $help = new \Dnoegel\PhpArgParse\HelpGenerator\HelpGenerator($output);
        $help->generate($parser);

        $this->assertRegExp("#^git:\s*A simple version control system#", $output->get());
        $this->assertRegExp("#--something, -s\s*Lorem ipsum#", $output->get());
        $this->assertRegExp("#--somethingElse, -e\s*Situs#", $output->get());

    }
}