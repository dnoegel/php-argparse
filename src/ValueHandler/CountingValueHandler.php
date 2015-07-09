<?php

namespace Argparse\ValueHandler;

class CountingValueHandler implements ValueHandler
{
    protected $count = 0;

    public function handle($value)
    {
        $this->count++;
    }

    public function getValue()
    {
        return $this->count;
    }
}