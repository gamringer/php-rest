<?php

namespace gamringer\PHPREST;

use GuzzleHttp\Psr7;

class HTTPEnvironment extends environment
{
    protected $request;

    public function __construct($environment, $output, $input, $headers)
    {
        $this->stdOut = Psr7\stream_for($output);
        $this->environment = $environment;

        list($protocolName, $protocolVersion) = explode('/', $environment['SERVER_PROTOCOL']);
        $this->request = new Psr7\Request(
            $environment['REQUEST_METHOD'],
            $environment['REQUEST_SCHEME'].'://'.$environment['HTTP_HOST'].$environment['REQUEST_URI'],
            $headers,
            $input,
            $protocolVersion
        );
    }

    public function getRequest()
    {
        return $this->request;
    }
}
