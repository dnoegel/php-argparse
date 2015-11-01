<?php

namespace Dnoegel\PhpArgParse\Handler;

use Dnoegel\PhpArgParse\Result\Result;

class CallbackHandler implements HandlerInterface
{
    /**
     * @var callable
     */
    private $callback;

    public function __construct(callable $callback)
    {

        $this->callback = $callback;
    }

    public function handle(Result $result)
    {
        $call = $this->callback;
        return $call($result);
    }

}