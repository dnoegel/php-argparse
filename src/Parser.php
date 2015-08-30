<?php

namespace Argparse;

use Argparse\Argument\Argument;
use Argparse\Argument\ArgumentFassade;
use Argparse\Argument\ArgumentInterface;
use Argparse\Handler\HandlerInterface;
use Argparse\Result\Result;

class Parser
{
    /** @var ArgumentInterface[] */
    protected $arguments = [];

    /**
     * @var HandlerInterface
     */
    protected $handler;

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
        $result = new Result($result, $this->arguments);

        $this->handler->handle($result);

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
        // create and add the argument
        $argument = new Argument(...$names);
        $this->add($argument);

        // wrap thee argument into a fassade, that will make handling the argument easier
        $facade = new ArgumentFassade($argument);

        return $facade;
    }

    public function setHandler(HandlerInterface $handler)
    {
        $this->handler = $handler;
    }

}