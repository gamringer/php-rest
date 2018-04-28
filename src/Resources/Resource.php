<?php

namespace gamringer\PHPREST\Resources;

use gamringer\PHPREST\Exceptions\RequestHandlingException;
use gamringer\PHPREST\Exceptions\MethodNotSupportedException;

abstract class Resource implements HasParent
{
    use Child;

    protected static $handlers = [];

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

    public function getFilters(?string $property = null): array
    {
        if ($property === null) {
            return $this->filters;
        }

        if (!array_key_exists($property, $this->filters)) {
            return [];
        }

        return $this->filters[$property];
    }

    public function getMethodHandler($method)
    {
        if (!array_key_exists($method, static::$handlers)) {
            throw new MethodNotSupportedException($this, 'Method '.$method.' is not supported by resource ' . static::class, 2);
        }

        return static::$handlers[$method];
    }

    public function getSupportedMethods()
    {
        return array_keys(static::$handlers);
    }
}
