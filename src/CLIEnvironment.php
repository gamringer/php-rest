<?php

namespace gamringer\PHPREST;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use \Psr\Http\Message\ResponseInterface;

class CLIEnvironment extends Environment
{
    public function __construct($environment, $output, $input)
    {
        $this->stdIn = Psr7\stream_for($input);
        $this->stdOut = Psr7\stream_for($output);
        $this->environment = $environment;
    }

    public function send(ResponseInterface $response): void
    {
        Psr7\copy_to_stream(Psr7\stream_for(Psr7\str($response)), $this->getStdOut());
    }
}
