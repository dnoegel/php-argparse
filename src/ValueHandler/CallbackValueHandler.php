<?php

namespace Argparse\ValueHandler;

class CallbackValueHandler implements ValueHandler
{
    /**
     * @var callable
     */
    private $callback;

    private $value;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function handle($value)
    {
        return $this->value = call_user_func($this->callback, $value, $this);
    }

    public function getValue()
    {
        return $this->value;
    }
}