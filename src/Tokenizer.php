<?php

namespace Argparse;

use Argparse\Argument\Argument;
use Argparse\Argument\ArgumentInterface;

class Tokenizer
{

    /** @var  Argument[] */
    private $args;

    public function __construct($args)
    {
        $this->args = $args;
    }

    public function run()
    {
        $stack = [];

        foreach ($this->args as $arg) {
            $long = strpos($arg, '--') === 0;
            $short = !$long && strpos($arg, '-') === 0;

            switch (true) {
                case $short;
                    foreach (str_split(ltrim($arg, '-')) as $key => $subarg) {
                        $token = new Token();
                        $token->type = $key == 0 ? Token::TOKEN_SHORT_OPTION : Token::TOKEN_OPTION_OR_VALUE;
                        $token->value = $key == 0 ? '-' . $subarg : $subarg;
                        $stack[] = $token;
                    }
                    break;
                case $long;
                    if (strpos($arg, '=') === false) {
                        $token = new Token();
                        $token->type = Token::TOKEN_OPTION;
                        $token->value = $arg;
                        $stack[] = $token;
                    } else {
                        $parts = explode('=', $arg);
                        $token = new Token();
                        $token->type = Token::TOKEN_OPTION;
                        $token->value = $parts[0];
                        $stack[] = $token;

                        $token = new Token();
                        $token->type = Token::TOKEN_VALUE;
                        $token->value = $parts[1];
                        $stack[] = $token;
                    }
                    break;
                default:
                    $token = new Token();
                    $token->type = Token::TOKEN_VALUE;
                    $token->value = $arg;
                    $stack[] = $token;
            }

            $token = new Token();
            $token->type = Token::TOKEN_NEW_WORD;
            $stack[] = $token;
        }


        if ($stack) {
            array_pop($stack);
        }

        return $stack;
    }
}