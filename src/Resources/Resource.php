<?php

namespace gamringer\PHPREST\Resources;

use gamringer\PHPREST\Exceptions\RequestHandlingException;

abstract class Resource implements HasParent
{
    use Child;

    protected $filters = [];

    protected static $controllers = [];

    public static function setController($method, callable $controller)
    {
        static::$controllers[$method] = $controller;
    }

    public function receive($request)
    {
        $method = $request->getMethod();
        if (!array_key_exists($request->getMethod(), static::$controllers)) {
            throw new RequestHandlingException('Resource does not support requested method');
        }

        static::$controllers[$method]($request);
    }

    public function addFilter($property, $value, $comparator = null)
    {
        if ($comparator === null) {
            $comparator = '=';
        }

        if (!array_key_exists($property, $this->filters)) {
            $this->filters[$property] = [];
        }

        $this->filters[$property][] = [
            'comparator' => $comparator,
            'value' => $value
        ];
    }
}
