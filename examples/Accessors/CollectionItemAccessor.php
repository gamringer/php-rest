<?php

namespace gamringer\PHPREST\Example\Accessors;

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

    private function tokenToGetter($token)
    {
        return 'get' . preg_replace_callback('/(?:^|[^a-z])([a-z])/', function ($match) {
            return strtoupper($match[1]);
        }, $token);
    }
}
