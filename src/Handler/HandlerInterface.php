<?php

namespace Argparse\Handler;

use Argparse\Result\Result;

/**
 * Interface HandlerInterface handles the result of a (sub) parser. This can be used, to handle
 * more complex console applications.
 *
 * @package Argparse\Handler
 */
interface HandlerInterface
{
    public function handle(Result $result);
}