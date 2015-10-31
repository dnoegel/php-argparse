<?php

namespace Dnoegel\PhpArgParse;

/**
 * Class ArgumentPopulator will iterate the tokens and populate the arguments corresponding to their configuration.
 *
 * @package Argparse
 */
class ArgumentPopulator
{
    /** @var  $arguments Argument\ArgumentInterface[] */
    private $arguments;

    public function __construct($arguments)
    {
        $this->arguments = $arguments;
    }

    public function populate($tokens)
    {
        /** @var Token $token */
        $currentArgument = null;

        $resultArguments = [];

        $position = 1;
        while ($tokens) {
            // skip new word markers
            while ($tokens[0]->type == Token::TOKEN_NEW_WORD) {
                array_shift($tokens);
            }

            // reference first token
            $token = $tokens[0];

            // try to get an argument from the token
            $argument = $this->getArgumentForOption($token);

            // If no argument was found, try to get a positional argument based on the current position
            if (!$argument && ($token->type == Token::TOKEN_VALUE || $token->type != Token::TOKEN_OPTION_OR_VALUE)) {
                $argument = $this->getArgumentByPosition($position);

                if (!$argument) {
                    throw new \RuntimeException("Could not associate $token->value");
                }
                $position++;
            }

            // if the argument cannot consume any additional words, set the current token
            if (!$argument->getConsume()) {
                $argument->setValue($token->value);

                // remove the token from the list
                array_shift($tokens);

            // if the argument consumes tokens:
            } else {
                // For non positional arguments, we want to remove the current token from the list,
                // so that e.g "--filter=test" consumes only "test" and not the "filter"
                if (!$argument->isPositional()) {
                    array_shift($tokens);
                }

                // now read $consume words from the token list
                foreach ($this->getWordsFromTokens($argument->getConsume(), $tokens) as $word) {
                    $argument->setValue($word);
                }
            }
            $resultArguments[] = $argument;
        }

        return $resultArguments;
    }

    /**
     * Read a given $number of tokens from the $tokens list
     *
     * @param $number
     * @param $tokens
     * @return array
     */
    private function getWordsFromTokens($number, &$tokens)
    {
        // skipp new words at the beginning
        if ($tokens[0]->type == Token::TOKEN_NEW_WORD) {
            array_shift($tokens);
        }

        $words = [];
        /** @var Token[] $tokens */

        for ($i = 0; $i < $number; $i++) {
            $parts = [];
            while ($tokens && $token = array_shift($tokens)) {
                if ($token->type == Token::TOKEN_NEW_WORD) {
                    if ($parts) {
                        $words[] = implode("", $parts);
                        $parts = [];
                        break;
                    } else {
                        continue;
                    }
                }

                if ($token->type != Token::TOKEN_VALUE && $token->type != Token::TOKEN_OPTION_OR_VALUE) {
                    throw new \RuntimeException("Could not satisfy $token->type::$token->value");
                }

                $parts[] = $token->value;
            }

            if ($parts) {
                $words[] = implode("", $parts);
            }
        }

        return $words;
    }

    /**
     * Find argument by token
     *
     * @param Token $token
     * @return Argument\ArgumentInterface|bool
     */
    private function getArgumentForOption(Token $token)
    {
        $searchFor = $token->type == Token::TOKEN_OPTION_OR_VALUE ? '-' . $token->value : $token->value;
        foreach ($this->arguments as $argument) {
            if (in_array($searchFor, $argument->getNames())) {
                return $argument;
            }
        }

        return false;
    }

    private function getArgumentByPosition($position)
    {
        $currentPosition = 1;
        foreach ($this->arguments as $argument) {
            if (strpos($argument->getNames()[0], '-') !== false) {
                continue;
            }
            if ($currentPosition != $position) {
                $currentPosition++;
                continue;
            }
            return $argument;
        }
        return false;
    }
}
