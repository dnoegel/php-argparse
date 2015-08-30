<?php

namespace Dnoegel\Phargparse;

use Dnoegel\Phargparse\Argument\ArgumentInterface;

/**
 * Class ArgumentValidator enforces, that all arguments with constraints (e.g. required, consume) are valid
 * @package Argparse
 */
class ArgumentValidator
{
    public function validate(ArgumentInterface $argument)
    {
        $value = $argument->getValue();

        if (!$argument->isRequired() && !$value) {
            return true;
        }

        if ($argument->isRequired() && !$argument->getConsume() && $value) {
            return true;
        }

        if ($argument->isRequired() && count($value) !== $argument->getConsume()) {
            throw new \RuntimeException("{$argument->getNames()[0]} required parameters not satisfied");
        }

        if ($value && $argument->getConsume() &&count($value) !== $argument->getConsume()) {
            throw new \RuntimeException("{$argument->getNames()[0]} parameters not satisfied");
        }
    }
}