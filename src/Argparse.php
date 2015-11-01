<?php

namespace Dnoegel\PhpArgParse;

use Dnoegel\PhpArgParse\HelpGenerator\HelpGenerator;
use Dnoegel\PhpArgParse\HelpGenerator\HelpGeneratorInterface;
use Dnoegel\PhpArgParse\OutputWriter\OutputWriterInterface;
use Dnoegel\PhpArgParse\OutputWriter\SimpleOutputWriter;
use Dnoegel\PhpArgParse\Result\Result;

class Argparse extends ArgumentCollection
{
    /** @var ArgumentCollection[] */
    protected $subParser = [];

    /** @var  HelpGeneratorInterface */
    private $helpGenerator;

    /** @var  OutputWriterInterface */
    private $output;

    public function addSubParser($name, $description = '')
    {
        return $this->subParser[$name] = new ArgumentCollection($name, $description);
    }

    public function parse($args)
    {
        if (in_array('-h', $args) || in_array('--help', $args)) {
            $this->printHelpText();
            return null;
        }

        $args = array_slice($args, 1);
        $parser = $this->getSubParserByArgs($args);
        if ($parser !== $this) {
            $args = array_slice($args, count(explode(" ", $parser->getName())));
        }

        $tokenizer = new Tokenizer($args);
        $tokens = $tokenizer->run();

        $populator = new ArgumentPopulator($parser->getArguments());
        try {
            $resultArguments = $populator->populate($tokens);
        } catch (\RuntimeException $e) {
            $this->handleInputException($e->getMessage());
        }

        $validator = new ArgumentValidator();
        foreach ($parser->getArguments() as $argument) {
            try {
                $validator->validate($argument);
            } catch (\RuntimeException $e) {
                $this->handleInputException($e->getMessage());
            }
        }

        $result = [];
        foreach ($parser->getArguments() as $argument) {
            foreach ($argument->getNames() as $name) {
                $result[$name] = $argument->getValue();
            }
        }
        $result = new Result($result, $parser->getArguments());

        if ($parser->getHandler()) {
            $parser->getHandler()->handle($result);
        }

        return $result;
    }

    public function printHelpText()
    {
        $this->getHelpGenerator()->generate($this);
    }

    /**
     * Return the parser in charge for the current request
     *
     * @param $args
     * @return ArgumentCollection
     */
    private function getSubParserByArgs($args)
    {
        $argString = implode(" ", $args);
        $resultingSubParser = null;
        foreach ($this->subParser as $name => $subParser) {
            if (stripos($argString, $name) === 0) {
                if (!$resultingSubParser || (strlen($resultingSubParser->getName()) < strlen($name))) {
                    $resultingSubParser = $subParser;
                }
            }
        }

        return $resultingSubParser ?: $this;
    }

    /**
     * @return ArgumentCollection[]
     */
    public function getSubParser()
    {
        return $this->subParser;
    }



    public function getOutputWriter()
    {
        if (!$this->output) {
            $this->output = new SimpleOutputWriter();
        }

        return $this->output;
    }

    public function setHelpGenerator(HelpGeneratorInterface $helpGenerator)
    {
        $this->helpGenerator = $helpGenerator;
    }


    /**
     * @return HelpGeneratorInterface
     */
    public function getHelpGenerator()
    {
        if (!$this->helpGenerator) {
            $this->helpGenerator = new HelpGenerator($this->getOutputWriter());
        }

        return $this->helpGenerator;
    }

    private function handleInputException($message)
    {
        $this->printHelpText();
        $this->getOutputWriter()->writeln("");
        $this->getOutputWriter()->writeln($message);
        exit(1);
    }
}
