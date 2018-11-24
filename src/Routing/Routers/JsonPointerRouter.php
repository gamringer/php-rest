<?php

namespace gamringer\PHPREST\Routing\Routers;

use gamringer\JSONPointer;
use gamringer\JSONPointer\Pointer;
use gamringer\PHPREST\Exceptions\ResourceNotFoundException;
use gamringer\PHPREST\Exceptions\RoutingException;
use gamringer\PHPREST\Resources\Resource;
use gamringer\PHPREST\Routing\ResourceRouterInterface;
use Psr\Http\Message\ServerRequestInterface;

class JsonPointerRouter implements ResourceRouterInterface
{
    protected $pointer;
    protected $root;
    protected $accessors;
    protected $dispatcher;

    public function __construct(&$root = null)
    {
        $this->pointer = new Pointer();
        if ($root !== null) {
            $this->setRoot($root);
        }
    }

    public function setRoot(&$root)
    {
        $this->root = &$root;
        $this->pointer->setTarget($root);

        $this->accessors = [];
        $this->fetchAccessors(get_class($root));

        $accessorCollection = $this->pointer->getAccessorCollection();
        foreach ($this->accessors as $type => $accessor) {
            $accessorCollection->setAccessor($type, new $accessor);
        }
    }

    public function fetchAccessors($resource)
    {
        $this->accessors[$resource] = $resource::$accessor;

        foreach ($resource::getPropertyModels() as $subResource) {
            if (array_key_exists($subResource, $this->accessors)) {
                continue;
            }

            $this->fetchAccessors($subResource);
        }
    }

    public function route(ServerRequestInterface $request): Resource
    {
        $path = $request->getUri()->getPath();

        try {
            $result = $this->pointer->get($path);
        } catch (JSONPointer\Exception $e) {
            throw new ResourceNotFoundException('Resource not found for path: ' . $path, 0, $e);
        }

        if ($result instanceof Resource) {
            return $result;
        }

        throw new RoutingException("Resource at $path is not a ".Resource::class);
    }
}
