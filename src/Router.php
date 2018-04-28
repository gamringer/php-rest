<?php

namespace gamringer\PHPREST;

use \gamringer\JSONPointer;
use \gamringer\JSONPointer\Pointer;
use \gamringer\PHPREST\Routing\ProvidesRoutes;
use \gamringer\PHPREST\Exceptions\ResourceNotFoundException;

class Router
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

    public function addProvider(ProvidesRoutes $provider)
    {
        $provider->feed($this);
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

    public function route($path)
    {
        try {
            return $this->pointer->get($path);
        } catch (JSONPointer\Exception $e) {
            throw new ResourceNotFoundException('Resource not found for path: ' . $path, 0, $e);
        }
    }
}
