<?php

namespace Argparse;

class Arguments
{
    /** @var ValueHandler\ValueHandler[] */
    protected $arguments = array();

    public function get($name)
    {
        return $this->arguments[$name];
    }

    public function has($name)
    {
        return isset($this->arguments[$name]);
    }
}