<?php

class TokenizerTest extends PHPUnit_Framework_TestCase
{
    private function split($line)
    {
        $splitter = new \Argparse\StringSplitter();
        return $splitter->split($line);
    }

    /**
     * @param $args
     * @return \Argparse\Token[]
     */
    private function tokenize($args)
    {
        $tokenizer = new \Argparse\Tokenizer($args);
        return $tokenizer->run();
    }

    public function testCombined()
    {
        $expected = [
            [\Argparse\Token::TOKEN_SHORT_OPTION, '-r'],
            [\Argparse\Token::TOKEN_OPTION_OR_VALUE, 'a'],
            [\Argparse\Token::TOKEN_OPTION_OR_VALUE, 'l'],
            [\Argparse\Token::TOKEN_OPTION_OR_VALUE, 's'],
            [\Argparse\Token::TOKEN_NEW_WORD, null],
            [\Argparse\Token::TOKEN_SHORT_OPTION, '-g'],
            [\Argparse\Token::TOKEN_NEW_WORD, null],
            [\Argparse\Token::TOKEN_VALUE, 'test'],
            [\Argparse\Token::TOKEN_NEW_WORD, null],
            [\Argparse\Token::TOKEN_OPTION, '--value'],
            [\Argparse\Token::TOKEN_NEW_WORD, null],
            [\Argparse\Token::TOKEN_OPTION, '--color'],
            [\Argparse\Token::TOKEN_VALUE, 'test'],
            [\Argparse\Token::TOKEN_NEW_WORD, null],
            [\Argparse\Token::TOKEN_OPTION, '--foo'],
            [\Argparse\Token::TOKEN_NEW_WORD, null],
            [\Argparse\Token::TOKEN_VALUE, 'bar'],
            [\Argparse\Token::TOKEN_NEW_WORD, null],
            [\Argparse\Token::TOKEN_VALUE, 'baz'],
        ];

        $tokens = $this->tokenize($this->split('-rals -g test --value --color=test --foo bar baz'));

        foreach ($tokens as $idx => $token) {
            $currentExpectation = $expected[$idx];
            $currentToken = $currentExpectation[0];
            $currentValue = $currentExpectation[1];
            $this->assertEquals($currentToken, $token->type);
            $this->assertEquals($currentValue, $token->value);
        }
    }
}