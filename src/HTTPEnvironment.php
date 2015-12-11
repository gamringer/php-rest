<?php

namespace gamringer\PHPREST;

use GuzzleHttp\Psr7;

class HTTPEnvironment extends Environment
{
    public function __construct()
    {
        $this->stdOut = Psr7\stream_for(fopen('php://output', 'w'));
    }

    public function getRequest()
    {
        list($protocolName, $protocolVersion) = explode('/', $_SERVER['SERVER_PROTOCOL']);
        return new Psr7\Request(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
            getallheaders(),
            fopen('php://input', 'r'),
            $protocolVersion
        );
    }
}
