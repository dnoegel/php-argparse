<?php

namespace Dnoegel\Phargparse\ValueHandler;

/**
 * Class ConstantValueHandler will store a constant value, which is useful for true/false flags
 * @package Argparse\ValueHandler
 */
class ConstantValueHandler implements ValueHandler
{
    /** @var  mixed */
    private $value = null;

    /** @var  mixed */
    private $constant;

    public function __construct($constant)
    {
        $this->constant = $constant;
    }

    public function handle($value)
    {
        return $this->value = $this->constant;
    }

    public function getValue()
    {
        return $this->value;
    }
}