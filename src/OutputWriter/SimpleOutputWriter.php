<?php

namespace Dnoegel\PhpArgParse\OutputWriter;

/**
 * Class SimpleOutputWriterInterface will just print any output for stdout.
 * @package Argparse\OutputWriter
 */
class SimpleOutputWriter implements OutputWriterInterface
{
    public function write($content)
    {
        echo $content;
    }

    public function writeln($content)
    {
        echo $content . "\n";
    }
}
