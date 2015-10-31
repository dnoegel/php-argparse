<?php

namespace Dnoegel\PhpArgParse\ValueHandler;

/**
 * Class StoreValueHandler will store a single given value. Typical example might be "--username", where
 * the actual username is then stored.
 *
 * @package Argparse\ValueHandler
 */
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
