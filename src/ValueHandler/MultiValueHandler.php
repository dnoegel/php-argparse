<?php

namespace Argparse\ValueHandler;

class MultiValueHandler implements ValueHandler
{
    private $values = [];

    public function handle($value)
    {
        $this->values[] = $value;
   }

    public function getValue()
    {
        return $this->values;
    }

}