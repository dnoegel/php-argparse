<?php

namespace Argparse;

use Argparse\Argument\Argument;
use Argparse\Argument\ArgumentFassade;
use Argparse\Argument\ArgumentInterface;

class Parser
{
    protected $arguments = [];


    public function parse($args)
    {
        $args = array_slice($args, 1);
        $tokenizer = new Tokenizer($args);
        $tokens = $tokenizer->run();

        $populator = new ArgumentPopulator($this->arguments);
        $resultArguments = $populator->populate($tokens);

        $validator = new ArgumentValidator();
        foreach ($this->arguments as $argument) {
            $validator->validate($argument);
        }

        $result =  [];
        foreach ($this->arguments as $argument) {
            foreach ($argument->getNames() as $name) {
                $result[$name] = $argument->getValue();
            }
        }

        return $result;

    }

    public function add(ArgumentInterface $argument)
    {
        foreach ($argument->getNames() as $name) {
            $this->arguments[$name] = $argument;
        }
        return $argument;
    }

    /**
     * @param ...$names
     * @return ArgumentFassade
     */
    public function addArgument(...$names)
    {
        return $this->add(new ArgumentFassade(new Argument(...$names)));
    }

}