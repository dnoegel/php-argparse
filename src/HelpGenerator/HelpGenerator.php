<?php

namespace Dnoegel\PhpArgParse\HelpGenerator;

use Dnoegel\PhpArgParse\Argument\Argument;
use Dnoegel\PhpArgParse\Argument\ArgumentInterface;
use Dnoegel\PhpArgParse\ArgumentCollection;
use Dnoegel\PhpArgParse\OutputWriter\OutputWriterInterface;

/**
 * Class HelpGenerator is the default help generator implementation of ArgParse
 * @package Dnoegel\PhpArgParse\HelpGenerator
 */
class HelpGenerator implements HelpGeneratorInterface
{
    const INDENT_STEP = 4;

    /**
     * @var OutputWriterInterface
     */
    private $writer;

    public function __construct(OutputWriterInterface $writer)
    {
        $this->writer = $writer;
    }

    /**
     * @param ArgumentCollection $argumentCollection
     * @param array $parents
     */
    public function generate(ArgumentCollection $argumentCollection, $parents=[])
    {
        $parentString = implode(' ', $parents);
        if ($parentString) {
            $parentString .= ' ';
        }
        $this->writer->writeln(str_pad('', count($parents)*self::INDENT_STEP, ' ') . $parentString . $argumentCollection->getName() . ":   " . $argumentCollection->getDescription());
        $this->writer->writeln("");

        $this->processArguments($argumentCollection, $parents);

        /** @var $subParser ArgumentCollection */
        if (method_exists($argumentCollection, 'getSubParser')) {
            if ($argumentCollection->getSubParser()) {
                $this->writer->writeln('Subcommands:');
            }

            foreach ($argumentCollection->getSubParser() as $subParser) {
                $this->generate($subParser, $parents + [$argumentCollection->getName()]);
                $this->writer->writeln("");
            }
        }
    }

    /**
     * @param $arguments
     * @return Argument[]
     */
    private function groupArguments($arguments)
    {
        $result = [];

        foreach ($arguments as $argument) {
            $result[spl_object_hash($argument)] = $argument;
        }

        return array_values($result);
    }

    /**
     * @param ArgumentCollection $argumentCollection
     * @internal param $arguments
     */
    protected function processArguments(ArgumentCollection $argumentCollection, $parents = [])
    {
        $arguments = $this->groupArguments($argumentCollection->getArguments());

        $longest = 0;
        $optionOutput = [];
        $argumentOutput = [];
        /** @var  $argument  ArgumentInterface */
        foreach ($arguments as $argument) {
            $key = implode(", ", $argument->getNames());
            if ($argument->isPositional()) {
                $argumentOutput[$key] = $argument;
            } else {
                $optionOutput[$key] = $argument;
            }

            $longest = strlen($key) > $longest ? strlen($key) : $longest;
        }

        if ($optionOutput) {
            $this->writer->writeln(str_pad('', 2*count($parents)*self::INDENT_STEP, ' ') . "Options: ");
        }
        foreach ($optionOutput as $name => $argument) {
            $name = str_pad($name, $longest, " ");
            $pad = str_pad('', 3*count($parents)*self::INDENT_STEP, ' ');
            $this->writer->writeln($pad . $name . "   " . $argument->getDescription());
        }

        if ($optionOutput) {
            $this->writer->writeln("");
        }


        if ($argumentOutput) {
            $this->writer->writeln(str_pad('', 2*count($parents)*self::INDENT_STEP, ' ') . "Arguments: ");
        }
        foreach ($argumentOutput as $name => $argument) {
            $name = str_pad($name, $longest, " ");
            $pad = str_pad('', 3*count($parents)*self::INDENT_STEP, ' ');
            $this->writer->writeln($pad . $name . "   " . $argument->getDescription());
        }
    }
}
