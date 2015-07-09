<?php

namespace Argparse\OutputWriter;

class SimpleOutputWriterInterface implements OutputWriterInterface
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