<?php

namespace Dnoegel\Phargparse\Argument;

use Dnoegel\Phargparse\ValueHandler\ConstantValueHandler;
use Dnoegel\Phargparse\ValueHandler\ValueHandler;

class Argument implements ArgumentInterface
{
    private $names;
    private $required;
    /** @var  ValueHandler */
    private $valueHandler;
    private $default;
    protected $consume;

    public function __construct(...$names)
    {
        $this->names = $names;
        $this->valueHandler = new ConstantValueHandler(true);
    }

    /**
     * @param ...$names
     * @return $this
     */
    public function setNames(...$names)
    {
        $this->names = $names;
        return $this;
    }

    /**
     * @param mixed $required
     * @return $this
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    public function isRequired()
    {
        return $this->required;
    }


    /**
     * @param mixed $valueHandler
     * @return $this
     */
    public function setValueHandler(ValueHandler $valueHandler)
    {
        $this->valueHandler = $valueHandler;
        return $this;
    }


    /**
     * @param mixed $default
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * @return mixed
     */
    public function getConsume()
    {
        return $this->consume;
    }

    /**
     * @param mixed $consume
     */
    public function setConsume($consume)
    {
        $this->consume = $consume;
    }

    public function setValue($value)
    {
        $this->valueHandler->handle($value);
    }


    public function getValue()
    {
        return $this->valueHandler->getValue();
    }

    public function isPositional()
    {
        return (strpos($this->getNames()[0], '-') === false);
    }

}