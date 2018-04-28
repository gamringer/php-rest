<?php

namespace gamringer\PHPREST\Accessors;

use gamringer\JSONPointer\Access\Accesses;
use gamringer\PHPREST\Resources\Resource;
use gamringer\JSONPointer\VoidValue;

class GetterAccessor implements Accesses
{
    public function hasValue(&$target, $token)
    {
        $getter = $this->tokenToGetter($token);

        return method_exists($target, $getter);
    }

    public function &getValue(&$target, $token)
    {
        $pointedValue = new VoidValue($target, $token);
        if ($this->hasValue($target, $token)) {
            $getter = $this->tokenToGetter($token);
            $pointedValue = $target->$getter();
            $pointedValue->setParent($target);
        }

        return $pointedValue;
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

    private function tokenToGetter($token)
    {
        return 'get' . preg_replace_callback('/(?:^|[^a-z])([a-z])/', function ($match) {
            return strtoupper($match[1]);
        }, $token);
    }
}
