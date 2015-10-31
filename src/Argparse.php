<?php

namespace Dnoegel\PhpArgParse;

use Dnoegel\PhpArgParse\Result\Result;

class Argparse extends ArgumentCollection
{
    /** @var ArgumentCollection[] */
    protected $subParser = [];

    public function addSubParser($name)
    {
        return $this->subParser[$name] = new ArgumentCollection($name);
    }

    public function parse($args)
    {
        $args = array_slice($args, 1);
        $parser = $this->getSubParserByArgs($args);
        if ($parser !== $this) {
            $args = array_slice($args, count(explode(" ", $parser->getName())));
        }

        $tokenizer = new Tokenizer($args);
        $tokens = $tokenizer->run();

        $populator = new ArgumentPopulator($parser->getArguments());
        $resultArguments = $populator->populate($tokens);

        $validator = new ArgumentValidator();
        foreach ($parser->getArguments() as $argument) {
            $validator->validate($argument);
        }

        $result =  [];
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
}
