<?php

namespace Dnoegel\Phargparse;


/**
 * Class StringSplitter splits a given string in a shell like manner, as e.g. $argv does
 *
 * @package Argparse
 */
class StringSplitter
{
    public function split($commandLineString)
    {
        // This regex was created by HamZa
        // http://stackoverflow.com/a/18217486/3605098
        preg_match_all('#(?<!\\\\)("|\')(?<escaped>(?:[^\\\\]|\\\\.)*?)\1|(?<unescaped>\S+)#s', $commandLineString, $matches, PREG_SET_ORDER);

        $results = array();
        foreach($matches as $array){
            if(!empty($array['escaped'])){
                $results[] = $array['escaped'];
            }else{
                $results[] = $array['unescaped'];
            }
        }
        return $results;
    }
}