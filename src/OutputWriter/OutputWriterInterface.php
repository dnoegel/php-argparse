<?php

namespace Argparse\OutputWriter;

interface OutputWriterInterface
{
    public function write($content);
    public function writeln($content);
}