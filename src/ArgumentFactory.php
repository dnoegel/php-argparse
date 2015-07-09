<?php

namespace Argparse;

use Argparse\Argument\OptionalArgument;
use Argparse\Argument\PositionalArgument;

class ArgumentFactory
{
    public static function createPositionalArgument($name)
    {
        return new PositionalArgument($name);
    }

    public static function createOptionalArgument($name)
    {
        return new OptionalArgument($name);
    }
}