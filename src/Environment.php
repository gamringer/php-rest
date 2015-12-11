<?php

namespace gamringer\PHPREST;

use GuzzleHttp\Psr7\Request;

class Environment
{
    protected $stdOut;

    public function getStdOut()
    {
        return $this->stdOut;
    }

    public static function fromGlobals()
    {
        if (PHP_SAPI == 'cli') {
            return new CLIEnvironment();
        }
        
        return new HTTPEnvironment();
    }
}
