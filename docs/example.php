<?php

use Dnoegel\PhpArgParse\Handler\CallbackHandler;
use Dnoegel\PhpArgParse\Result\Result;
use Dnoegel\PhpArgParse\ValueHandler\StoreValueHandler;

require '../vendor/autoload.php';

// this is an example result handler for the `git clone` command
class CloneHandler implements Dnoegel\PhpArgParse\Handler\HandlerInterface
{
    public function handle(Result $result)
    {
        $repo = $result->get('repository');
        $dir = $result->get('directory');

        echo "Clone $repo to $dir\n";
    }
}

// this is a anonymous function used as a result handler
$result_handler = function (Result $result) {
    if ($result->get('--version')) {
        echo "1.0.0\n";
        return;
    }
};

// Create the parser for our `git` command
$parser = new \Dnoegel\PhpArgParse\Argparse('git', 'A simple version control system');
// the `git` command has a `--version` argument
$parser->addArgument('-v', '--version');
// which is handled by our anonymous function
$parser->setHandler(new CallbackHandler($result_handler));

// Also there is a `git clone` command handled by a subParser
$clone = $parser->addSubParser('clone', 'Copies a remote repository to a local directory');
// it has an optional `--verbose` flag
$clone->addArgument('-v', '--verbose')->setDescription('Verbose');
// a required `repository` flag
$clone->addArgument('repository')
    ->setDescription('Name of the repository you want to clone')
    ->setRequired(1)
    ->setValueHandler(new StoreValueHandler());
// and a required `directory` flag
$clone->addArgument('directory')
    ->setDescription('Path you want to clone the repository to')
    ->setRequired(1)
    ->setValueHandler(new StoreValueHandler());
// and the whole `git clone` subParser result is handled by our `CloneHandler` class
$clone->setHandler(new CloneHandler());

// `git checkout`
$checkout = $parser->addSubParser('checkout');

// without the `parse` method call, nothing will happen
$parser->parse($argv);
