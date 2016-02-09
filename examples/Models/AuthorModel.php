<?php

namespace gamringer\PHPREST\Example\Models;

use \Psr\Http\Message\RequestInterface;
use \gamringer\PHPREST\Resources\Item as BaseItem;
use \gamringer\PHPREST\Example\Models\Collections\BookCollection;

class AuthorModel extends BaseItem
{
    public static $accessor = \gamringer\PHPREST\Example\Accessors\GetterAccessor::class;

    public static $properties = [
        'books' => BookCollection::class,
    ];

    public function __construct($slug = null)
    {
        if ($slug === null) {
            return;
        }

        if (is_numeric($slug)) {
            $this->addFilter('id', $slug);
        }
    }

    public function getBooks()
    {
        return new BookCollection();
    }
}
