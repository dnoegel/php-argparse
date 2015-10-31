<?php

namespace Dnoegel\PhpArgParse;

use Dnoegel\PhpArgParse\Argument\Argument;
use Dnoegel\PhpArgParse\Argument\ArgumentInterface;

/**
 * Class Tokenizer takes an $args array and split it into smaller tokens, so we have a more shell-like
 * experience like `tar -cvzf filename.tar.gz input` where the first the short options don't consume
 * any items, but "f" does consume the next value
 *
 * @package Argparse
 */
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
                        // the first short option is a short option for sure, any later short opten could also be
                        // value of the previous short option
                        $token->type = $key == 0 ? Token::TOKEN_SHORT_OPTION : Token::TOKEN_OPTION_OR_VALUE;
                        $token->value = $key == 0 ? '-' . $subarg : $subarg;
                        $stack[] = $token;
                    }
                    break;
                case $long;
                    // if no = in $arg, just push TOKEN_OPTION
                    if (strpos($arg, '=') === false) {
                        $token = new Token();
                        $token->type = Token::TOKEN_OPTION;
                        $token->value = $arg;
                        $stack[] = $token;
                    // if = found, push TOKEN_OPTION and TOKEN_VALUE
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


        // pop the last TOKEN_NEW_WORD
        if ($stack) {
            array_pop($stack);
        }

        return $stack;
    }
}
