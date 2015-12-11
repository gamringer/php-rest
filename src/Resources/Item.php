<?php

namespace gamringer\PHPREST\Resources;

class Item extends Resource
{
    public function fetch($id)
    {
        
    }

    public static function getPropertyModels()
    {
        return array_values(static::$properties);
    }
}
