<?php

namespace Dnoegel\PhpArgParse;

use Dnoegel\PhpArgParse\Argument\Argument;
use Dnoegel\PhpArgParse\Argument\ArgumentFassade;
use Dnoegel\PhpArgParse\Argument\ArgumentInterface;
use Dnoegel\PhpArgParse\Handler\HandlerInterface;

/**
 * Class ArgumentCollection represents a set of arguments belonging to a certain (sub) parser
 * @package Dnoegel\PhpArgParse
 */
class ArgumentCollection
{
    /** @var ArgumentInterface[] */
    protected $arguments = [];

    /**
     * @var HandlerInterface
     */
    protected $handler;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $description;

    public function __construct($name = null, $description = null)
    {
        $this->name = $name;
        $this->description = $description;
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

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return ArgumentInterface[]
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return HandlerInterface
     */
    public function getHandler()
    {
        return $this->handler;
    }
}
