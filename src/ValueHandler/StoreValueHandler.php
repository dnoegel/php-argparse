<?php

namespace Argparse\ValueHandler;

class StoreValueHandler implements ValueHandler
{
    protected $value;

    public function handle($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

}