<?php

namespace gamringer\PHPREST\Resources;

abstract class Collection extends Resource implements CollectsItems
{
    public function getCollectionItem($slug)
    {
        $class = $this::getCollectionItemModel();
        
        $item = new $class($slug);
        $item->setParent($this);

        return $item;
    }

    public static function getPropertyModels()
    {
        return [static::getCollectionItemModel()];
    }
}
