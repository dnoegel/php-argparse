<?php

namespace Argparse\Argument;

interface ArgumentInterface
{
    public function setNames(...$names);
    public function setValue($value);


    public function getNames();
    public function getConsume();
    public function isPositional();
    public function isRequired();
    public function getValue();
}