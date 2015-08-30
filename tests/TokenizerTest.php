<?php

class TokenizerTest extends PHPUnit_Framework_TestCase
{
    private function split($line)
    {
        $splitter = new \Dnoegel\Phargparse\StringSplitter();
        return $splitter->split($line);
    }

    /**
     * @param $args
     * @return \Dnoegel\Phargparse\Token[]
     */
    private function tokenize($args)
    {
        $tokenizer = new \Dnoegel\Phargparse\Tokenizer($args);
        return $tokenizer->run();
    }

    public function testCombined()
    {
        $expected = [
            [\Dnoegel\Phargparse\Token::TOKEN_SHORT_OPTION, '-r'],
            [\Dnoegel\Phargparse\Token::TOKEN_OPTION_OR_VALUE, 'a'],
            [\Dnoegel\Phargparse\Token::TOKEN_OPTION_OR_VALUE, 'l'],
            [\Dnoegel\Phargparse\Token::TOKEN_OPTION_OR_VALUE, 's'],
            [\Dnoegel\Phargparse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\Phargparse\Token::TOKEN_SHORT_OPTION, '-g'],
            [\Dnoegel\Phargparse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\Phargparse\Token::TOKEN_VALUE, 'test'],
            [\Dnoegel\Phargparse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\Phargparse\Token::TOKEN_OPTION, '--value'],
            [\Dnoegel\Phargparse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\Phargparse\Token::TOKEN_OPTION, '--color'],
            [\Dnoegel\Phargparse\Token::TOKEN_VALUE, 'test'],
            [\Dnoegel\Phargparse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\Phargparse\Token::TOKEN_OPTION, '--foo'],
            [\Dnoegel\Phargparse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\Phargparse\Token::TOKEN_VALUE, 'bar'],
            [\Dnoegel\Phargparse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\Phargparse\Token::TOKEN_VALUE, 'baz'],
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