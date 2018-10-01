<?php

namespace gamringer\PHPREST\Example\Models;

use \gamringer\PHPREST\Resources\Item as BaseItem;
use \gamringer\PHPREST\Example\Models\AuthorModel;

class BookModel extends BaseItem
{
    public static $accessor = \gamringer\PHPREST\Accessors\GetterAccessor::class;

    public static $properties = [
        'author' => AuthorModel::class,
    ];

    public function __construct($slug)
    {
        if ($slug === null) {
            return;
        }

        if (is_numeric($slug)) {
            $this->addFilter('id', $slug);
        }
    }

    public function getAuthor()
    {
        return new AuthorModel();
    }
}
