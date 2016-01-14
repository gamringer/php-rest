<?php

namespace gamringer\PHPREST;

use \gamringer\JSONPointer\Pointer;
use \Psr\Http\Message\RequestInterface;
use \GuzzleHttp\Psr7;

class JPDispatcher
{
    protected $router;
    protected $pathLocation = '';
    protected $resourceControllers = [];

    public function __construct(JPRouter $router)
    {
        $this->router = $router;
    }

    public function setPathLocation($pathLocation)
    {
        $this->pathLocation = $pathLocation;
    }

    public function getApplicationPath($path)
    {
        if (!empty($this->pathLocation)) {
            $path = preg_replace('#^'.$this->pathLocation.'#', '', $path);
        }

        return $path;
    }

    public function dispatch(RequestInterface $request)
    {
        $path = $this->getApplicationPath($request->getUri()->getPath());
        $resource = $this->router->route($path);
        
        $resourceFQCN = get_class($resource);
        if (!array_key_exists($resourceFQCN, $this->resourceControllers)) {
            throw new Exception('Routed resource not handled');
        }
        if (!array_key_exists($request->getMethod(), $this->resourceControllers[$resourceFQCN])) {
            throw new Exception('Method not handled for the routed resource');
        }

        $this->resourceControllers[$resourceFQCN][$request->getMethod()]($request, $resource);

        $response = new Psr7\Response(200, [
            'Content-Type' => 'application/json'
        ], 'salut');

        return $response;
    }
}
