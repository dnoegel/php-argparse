<?php

namespace Dnoegel\Phargparse\ValueHandler;

/**
 * Interface ValueHandler is the generic definition of an value handler. A value handler will handle all
 * input values for a given argument, typical use cases are:
 *  * store a constant value (e.g. if argument is set, store "true")
 *  * count number of occurences (e.g. -vvv will set verbosity to 3)
 *  * store multiple values (e.g. 3 files to delete)
 *
 * @package Argparse\ValueHandler
 */
interface ValueHandler
{
    public function handle($value);
    public function getValue();
}