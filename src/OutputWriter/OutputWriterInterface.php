<?php

namespace Argparse\OutputWriter;

/**
 * Interface OutputWriterInterface describes an output interface (like stdout)
 * @package Argparse\OutputWriter
 */
interface OutputWriterInterface
{
    public function write($content);
    public function writeln($content);
}