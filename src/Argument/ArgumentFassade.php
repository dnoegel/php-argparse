<?php

namespace Argparse\Argument;

use Argparse\ValueHandler\CallbackValueHandler;
use Argparse\ValueHandler\ConstantValueHandler;
use Argparse\ValueHandler\ValueHandler;

class ArgumentFassade implements ArgumentInterface
{

    /**
     * @var Argument
     */
    private $argument;

    public function __construct(ArgumentInterface $argument)
    {
        $this->argument = $argument;
    }

    public function setNames(...$names)
    {
        $this->argument->setNames(...$names);
        return $this;
    }

    public function setRequired($required)
    {
        $this->argument->setRequired($required);
        return $this;
    }

    public function setValueHandler($handler)
    {
        switch (true) {
            case $handler instanceof ValueHandler;
                break;
            case is_callable($handler):
                $handler = new CallbackValueHandler($handler);
                break;
            default:
                $handler = new ConstantValueHandler($handler);
        }

        $this->argument->setValueHandler($handler);
        return $this;
    }

    public function getValue()
    {
        return $this->argument->getValue();
    }

    /**
     * @return mixed
     */
    public function getNames()
    {
        return $this->argument->getNames();
    }


    public function getConsume()
    {
        return $this->argument->getConsume();
    }

    public function setConsume($consume)
    {
        $this->argument->setConsume($consume);
        return $this;
    }

    public function setValue($value)
    {
        $this->argument->setValue($value);
    }

    public function isPositional()
    {
        return $this->argument->isPositional();
    }


    public function isRequired()
    {
        return $this->argument->isRequired();
    }

}