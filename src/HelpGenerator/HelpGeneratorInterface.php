<?php

namespace Dnoegel\PhpArgParse\HelpGenerator;

use Dnoegel\PhpArgParse\ArgumentCollection;

/**
 * Interface HelpGeneratorInterface describes a generator for "--help" like messages of a command
 * @package Dnoegel\PhpArgParse\HelpGenerator
 */
interface HelpGeneratorInterface
{
    public function generate(ArgumentCollection $argumentCollection);
}
