<?php

namespace gamringer\PHPREST;

use GuzzleHttp\Psr7\Request;

class CLIEnvironment extends Environment
{
    public function __construct()
    {
        $this->stdOut = STDOUT;
    }
}
