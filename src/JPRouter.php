<?php

namespace gamringer\PHPREST;

use \gamringer\JSONPointer\Pointer;

class JPRouter
{
    protected $pointer;
    protected $root;
    protected $accessors;

    public function __construct()
    {
        $this->pointer = new Pointer();
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
        return $this->pointer->get($path);
    }
}
