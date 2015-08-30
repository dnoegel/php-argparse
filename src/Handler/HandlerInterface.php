<?php

namespace Dnoegel\Phargparse\Handler;

use Dnoegel\Phargparse\Result\Result;

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