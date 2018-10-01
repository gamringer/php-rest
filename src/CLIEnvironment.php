<?php

namespace gamringer\PHPREST;

use GuzzleHttp\Psr7\Request;

class CLIEnvironment extends Environment
{
    public function __construct($environment, $output, $input)
    {
        $this->stdIn = \GuzzleHttp\Psr7\stream_for($input);
        $this->stdOut = \GuzzleHttp\Psr7\stream_for($output);
        $this->environment = $environment;
    }
}
