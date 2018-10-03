<?php

namespace gamringer\PHPREST\Middlewares;

use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Server\MiddlewareInterface;
use \Psr\Http\Server\RequestHandlerInterface;

class CatchAll implements MiddlewareInterface
{
    protected $errorController;
    protected $errorLog;

    public function __construct($errorController, $errorLog)
    {
        $this->errorController = $errorController;
        $this->errorLog = $errorLog;

        set_error_handler([$this, 'errorHandler']);
        register_shutdown_function([$this, 'shutdownHandler'], $errorLog);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $controller = $this->errorController;
        try {
            return $handler->handle($request);

        } catch (\ErrorException $e) {
            $this->errorLog->error($e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            return $controller($request, $e);

        } catch (\Throwable $e) {
            $this->errorLog->error($e->getMessage());
            return $controller($request, $e);

        }
    }

    public function errorHandler( $errno , $errstr, $errfile, $errline, $errcontext)
    {
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

    public function shutdownHandler( $errorLog )
    {
        $error = error_get_last();
        if ($error === null) {
                return;
        }

        $this->errorLog->critical($error['message'] . ' in ' . $error['file'] . ' on line ' . $error['line']);
    }
}
