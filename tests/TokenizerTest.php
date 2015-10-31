<?php

class TokenizerTest extends PHPUnit_Framework_TestCase
{
    private function split($line)
    {
        $splitter = new \Dnoegel\PhpArgParse\StringSplitter();
        return $splitter->split($line);
    }

    /**
     * @param $args
     * @return \Dnoegel\PhpArgParse\Token[]
     */
    private function tokenize($args)
    {
        $tokenizer = new \Dnoegel\PhpArgParse\Tokenizer($args);
        return $tokenizer->run();
    }

    public function testCombined()
    {
        $expected = [
            [\Dnoegel\PhpArgParse\Token::TOKEN_SHORT_OPTION, '-r'],
            [\Dnoegel\PhpArgParse\Token::TOKEN_OPTION_OR_VALUE, 'a'],
            [\Dnoegel\PhpArgParse\Token::TOKEN_OPTION_OR_VALUE, 'l'],
            [\Dnoegel\PhpArgParse\Token::TOKEN_OPTION_OR_VALUE, 's'],
            [\Dnoegel\PhpArgParse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\PhpArgParse\Token::TOKEN_SHORT_OPTION, '-g'],
            [\Dnoegel\PhpArgParse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\PhpArgParse\Token::TOKEN_VALUE, 'test'],
            [\Dnoegel\PhpArgParse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\PhpArgParse\Token::TOKEN_OPTION, '--value'],
            [\Dnoegel\PhpArgParse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\PhpArgParse\Token::TOKEN_OPTION, '--color'],
            [\Dnoegel\PhpArgParse\Token::TOKEN_VALUE, 'test'],
            [\Dnoegel\PhpArgParse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\PhpArgParse\Token::TOKEN_OPTION, '--foo'],
            [\Dnoegel\PhpArgParse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\PhpArgParse\Token::TOKEN_VALUE, 'bar'],
            [\Dnoegel\PhpArgParse\Token::TOKEN_NEW_WORD, null],
            [\Dnoegel\PhpArgParse\Token::TOKEN_VALUE, 'baz'],
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
