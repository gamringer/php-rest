<?php

namespace gamringer\PHPREST\Accessors;

use gamringer\JSONPointer\Access\Accesses;

class CollectionItemAccessor implements Accesses
{
    public function hasValue(&$target, $token)
    {
        return true;
    }

    public function &getValue(&$target, $token)
    {
        $value = $target->getCollectionItem($token);

        return $value;
    }

    public function &setValue(&$target, $token, &$value)
    {
    }

    public function unsetValue(&$target, $token)
    {
    }

    public function covers(&$target)
    {
        return true;
    }
}
