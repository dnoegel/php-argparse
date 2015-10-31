<?php

namespace Dnoegel\PhpArgParse\ValueHandler;

/**
 * Class CountingValueHandler will count any occurrence of a given value. Useful for e.g. verbosity flags,
 * where -vvv will internally actually store "3".
 *
 * @package Argparse\ValueHandler
 */
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
