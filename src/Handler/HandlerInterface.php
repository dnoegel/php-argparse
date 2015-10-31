<?php

namespace Dnoegel\PhpArgParse\Handler;

use Dnoegel\PhpArgParse\Result\Result;

/**
 * Interface HandlerInterface handles the result of a (sub) parser. This can be used, to handle
 * more complex console applications.
 *
 * @package Namespace\Handler
 */
interface HandlerInterface
{
    public function handle(Result $result);
}
