<?php

namespace Argparse;

use Argparse\OutputWriter\SimpleOutputWriterInterface;

class Argparse
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var null
     */
    private $output;

    public function __construct($name = '', $output = null)
    {
        $this->name = $name;

        if (!$output) {
            $output = new SimpleOutputWriterInterface();
        }

        $this->output = $output;
    }
}