<?php

namespace Dnoegel\PhpArgParse\Argument;

interface ArgumentInterface
{
    public function setNames(...$names);
    public function setValue($value);
    public function setValidator(\Closure $callable);
    public function validate(ArgumentInterface $argument);
    public function setDescription($description);

    public function getNames();
    public function getConsume();
    public function isPositional();
    public function isRequired();
    public function getValue();
    public function getDescription();
}
