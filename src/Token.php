<?php

namespace Argparse;

/**
 * Class Token represents a single token of the commandline arguments passed to the script. E.g.
 * "-f", "--filter" or "/home/user/test.zip"
 *
 * @package Argparse
 */
class Token
{
    const TOKEN_VALUE = 'value';
    const TOKEN_OPTION = 'option';
    const TOKEN_OPTION_OR_VALUE = 'option_or_value';
    const TOKEN_NEW_WORD = 'end_word';
    const TOKEN_SHORT_OPTION = 'short_option';

    public $value;
    public $type;
}