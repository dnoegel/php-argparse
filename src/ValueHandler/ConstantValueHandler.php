<?php

namespace Argparse\ValueHandler;

class ConstantValueHandler implements ValueHandler
{
    /**
     * @var
     */
    private $constant;

    public function __construct($constant)
    {

        $this->constant = $constant;
    }

    public function handle($value)
    {
        return $this->constant;
    }

    public function getValue()
    {
        return $this->constant;
    }


}