<?php

namespace gamringer\PHPREST;

use GuzzleHttp\Psr7\Request;

class Environment
{
    protected $stdOut;
    protected $environment;

    public function getStdOut()
    {
        return $this->stdOut;
    }

    public static function fromGlobals()
    {
        if (PHP_SAPI == 'cli') {
            return new CLIEnvironment($_SERVER, STDOUT, STDIN, STDERR);
        }
        
        return new HTTPEnvironment($_SERVER, fopen('php://output', 'w'), fopen('php://input', 'r'), getallheaders());
    }

    public function getValue($index)
    {
        return $this->environment[$index];
    }
}
