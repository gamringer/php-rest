<?php

namespace gamringer\PHPREST\Example\Models\Collections;

use \gamringer\PHPREST\Resources\Collection as BaseCollection;
use gamringer\PHPREST\Resources\CollectsItems;
use gamringer\PHPREST\Example\Models\BookModel;

class BookCollection extends BaseCollection
{
    public static $accessor = \gamringer\PHPREST\Example\Accessors\CollectionItemAccessor::class;

    public function __construct()
    {
        
    }

    public static function getCollectionItemModel()
    {
        return BookModel::class;
    }
}
