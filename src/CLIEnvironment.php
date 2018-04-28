<?php

namespace gamringer\PHPREST;

use GuzzleHttp\Psr7\Request;

class CLIEnvironment extends Environment
{
    public function __construct($environment, $output, $input)
    {
        $this->stdIn = Psr7\stream_for($input);
        $this->stdOut = Psr7\stream_for($output);
        $this->environment = $environment;
    }
}
