# PHP Argument Parser - Phargparse
Phargparse is a simple WORK IN PROGRESS argument parser for PHP.

# Usecase / intention
Writing PHP script for the commandline is easy - but usually it will fall short in argument
handling. `getopt` only provides rudimentary handling of arguments, the
[symfony console tools](http://symfony.com/doc/current/components/console/introduction.html)
are very powerful but are way more then just "argument handling" and make quite some assumptions
of how your code should look.

Phargparse is inspired by [python's argparse](https://docs.python.org/3/library/argparse.html)
and is intended to:

 * allow simple definition of arguments
 * generate docs for those arguments
 * validate the user input against the argument definition

# Features
## Currently working

 * definition of multiple arguments
 * definition of multiple subparser to allow sub-commands like `git`, `git clone` or `git init`
 * supports chained short arguments with value consumption, e.g. `watch -n1` where the `1` is
 consumed as a value by `n`
 * flexible value handlers to have control about **how** values are handled (e.g. list, count, store)
 * agnostic to your framework and patterns - you can specify handler classes per (sub)parser or
 just use the result of the `parse` call

## Not yet implemented

 * generating docs (e.g. --help page)
 * better validation
 * wildcard operators like "*" or "?" for the `consume` property
 * grouping of arguments

# How to use it?

```
$parser = new \Dnoegel\Phargparse\Argparse();

// each -v or --value will increase the verbosityy count
$parser->addArgument('-v', '--verbose')->setValueHandler(new CountingValueHandler());
// consume one value and store it
$parser->addArgument('-n')->setConsume(1)->setValueHandler(new StoreValueHandler());
// don't consume anything, just store `true`
$parser->addArgument('--colors')->setValueHandler(new ConstantValueHandler(true));
// consume one value and store it
$parser->addArgument('--filter')->setValueHandler(new StoreValueHandler())->setConsume(1);
// consume one value and store it
$parser->addArgument('--anotherFilter')->setValueHandler(new StoreValueHandler())->setConsume(1);
// consume one value and store it - this param is not required, so we can leave it empty later
$parser->addArgument('--randomParam')->setValueHandler(new MultiValueHandler())->setConsume(1);
// consume three values and store them all
$parser->addArgument('files')->setValueHandler(new MultiValueHandler())->setConsume(3);
// when finished with parsing, call the `handle` method on our handler
$parser->setHandler(new MyCustomHandler());

// if we don't want to use handlers, we can also just use the `Result` object of the `parse` method
$result = $parser->parse([
    '/usr/bin/tst', '--colors', '-vvn1',
    '-v', '--filter', 'hallo welt"',
    '--anotherFilter=test',
    'foo', 'bar', 'baz'
])
```

The result will look like this:

```
[
    '-v' => 3,
    '--verbose' => 3,
    '-n' => 1,
    '--colors' => true,
    '--filter' => 'hallo welt"',
    '--anotherFilter' => 'test',
    '--randomParam' => [],
    'files' => [
        'foo', 'bar', 'baz'
    ]
]
 ```