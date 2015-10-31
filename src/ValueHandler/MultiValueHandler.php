<?php

namespace Dnoegel\PhpArgParse\ValueHandler;

/**
 * Class MultiValueHandler store a collection of values, e.g. a list of file names.
 *
 * @package Argparse\ValueHandler
 */
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
