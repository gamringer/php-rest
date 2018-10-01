<?php

namespace gamringer\PHPREST\Example;

use \gamringer\PHPREST\Resources\Item as BaseItem;

class FooAPI extends BaseItem
{
    public static $accessor = \gamringer\PHPREST\Example\Accessors\GetterAccessor::class;

    public static $properties = [
        'authors' => \gamringer\PHPREST\Example\Models\Collections\AuthorCollection::class,
        'books' => \gamringer\PHPREST\Example\Models\Collections\BookCollection::class,
    ];

    protected static $handlers = [
        'GET' => 'handler.root-get',
    ];

    protected $authors;
    protected $books;

    public function __construct()
    {

    }

    public static function getRoot()
    {
        return new static();
    }

    public function getAuthorsProperty()
    {
        return new $this->properties['authors']();
    }

    public function getBooksProperty()
    {
        return new $this->properties['books']();
    }

    public function getAuthors()
    {
        return new self::$properties['authors']();
    }

    public function getBooks()
    {
        return new self::$properties['books']();
    }

    public function get()
    {
        return $this;
    }
}
