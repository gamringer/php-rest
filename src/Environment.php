<?php

declare(strict_types=1);

namespace gamringer\PHPREST;

use GuzzleHttp\Psr7\Request;

class Environment
{
    protected $stdOut;
    protected $stdIn;
    protected $environment;

    public function getStdOut()
    {
        return $this->stdOut;
    }

    public static function fromGlobals(): Environment
    {
        if (PHP_SAPI == 'cli') {
            return new CLIEnvironment($_SERVER, STDOUT, STDIN);
        }

        return new HTTPEnvironment($_SERVER, fopen('php://output', 'w'), fopen('php://input', 'r+'), [
            'get' => $_GET,
            'post' => $_POST,
            'files' => $_FILES,
            'cookies' => $_COOKIE,
        ]);
    }

    public function getValue($index)
    {
        return $this->environment[$index];
    }
}
