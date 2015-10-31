<?php

namespace Dnoegel\PhpArgParse\Argument;

use Dnoegel\PhpArgParse\ValueHandler\CallbackValueHandler;
use Dnoegel\PhpArgParse\ValueHandler\ConstantValueHandler;
use Dnoegel\PhpArgParse\ValueHandler\ValueHandler;

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

    public function setValidator(\Closure $callable)
    {
        $this->argument->setValidator($callable);
    }

    public function validate(ArgumentInterface $argument)
    {
        return $this->argument->validate($argument);
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->argument->getDescription();
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->argument->setDescription($description);
    }

}
