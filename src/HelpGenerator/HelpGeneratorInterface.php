<?php

namespace Dnoegel\PhpArgParse\HelpGenerator;

use Dnoegel\PhpArgParse\ArgumentCollection;

interface HelpGeneratorInterface
{
    public function generate(ArgumentCollection $argumentCollection);
}