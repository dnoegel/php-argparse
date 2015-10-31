<?php

namespace Dnoegel\PhpArgParse\HelpGenerator;

use Dnoegel\PhpArgParse\Argument\Argument;
use Dnoegel\PhpArgParse\ArgumentCollection;
use Dnoegel\PhpArgParse\OutputWriter\OutputWriterInterface;

class HelpGenerator implements HelpGeneratorInterface
{
    /**
     * @var OutputWriterInterface
     */
    private $writer;

    public function __construct(OutputWriterInterface $writer)
    {
        $this->writer = $writer;
    }

    public function generate(ArgumentCollection $argumentCollection)
    {
        $arguments = $this->groupArguments($argumentCollection->getArguments());

        $this->writer->writeln($argumentCollection->getName() . ":   " . $argumentCollection->getDescription());
        $this->writer->writeln("");


        $longest = 0;
        $argumentsOutput = [];
        foreach ($arguments as $argument) {
            $key = implode(", ", $argument->getNames());
            $value = $argument->getDescription();
            $argumentsOutput[$key] = $value;

            $longest = strlen($key) > $longest ? strlen($key) : $longest;

        }

        foreach ($argumentsOutput as $name => $desc) {
            $name = str_pad($name, $longest, " ");
            $this->writer->writeln($name . "   " . $desc);
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
}