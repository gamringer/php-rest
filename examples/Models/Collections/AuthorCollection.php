<?php

namespace gamringer\PHPREST\Example\Models\Collections;

use \gamringer\PHPREST\Resources\Collection as BaseCollection;
use gamringer\PHPREST\Resources\CollectsItems;
use gamringer\PHPREST\Example\Models\AuthorModel;

class AuthorCollection extends BaseCollection
{
    public static $accessor = \gamringer\PHPREST\Accessors\CollectionItemAccessor::class;

    public function __construct()
    {

    }

    public static function getCollectionItemModel()
    {
        return AuthorModel::class;
    }
}
