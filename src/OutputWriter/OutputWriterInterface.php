<?php

namespace Dnoegel\PhpArgParse\OutputWriter;

/**
 * Interface OutputWriterInterface describes an output (like stdout)
 * @package Argparse\OutputWriter
 */
interface OutputWriterInterface
{
    public function write($content);
    public function writeln($content);
}
