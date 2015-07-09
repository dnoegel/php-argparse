<?php

namespace Argparse\ValueHandler;

interface ValueHandler
{
    public function handle($value);
    public function getValue();
}