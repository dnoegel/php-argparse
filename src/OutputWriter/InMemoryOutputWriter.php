<?php

namespace Argparse\OutputWriter;

class InMemoryOutputWriter implements OutputWriterInterface
{
    protected $memory;

    public function write($content)
    {
        $this->memory .= $content;
    }

    public function writeln($content)
    {
        $this->memory .= $content . "\n";
    }

    public function get()
    {
        return $this->memory;
    }
}