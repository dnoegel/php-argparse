<?php

namespace Dnoegel\PhpArgParse\Result;

use Dnoegel\PhpArgParse\Argument\ArgumentInterface;

class Result
{
    private $result;
    private $arguments;

    public function __construct($result, $arguments)
    {
        $this->result = $result;
        $this->arguments = $arguments;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->result[$name];
    }

    /**
     * @param $name
     * @return ArgumentInterface
     */
    public function getArgument($name)
    {
        return $this->arguments[$name];
    }
}
