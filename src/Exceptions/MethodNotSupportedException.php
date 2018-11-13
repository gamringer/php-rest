<?php

namespace gamringer\PHPREST\Exceptions;

use gamringer\PHPREST\Resources\Resource;

class MethodNotSupportedException extends RoutingException
{
    protected $resource;

    public function __construct(Resource $resource, $message = '', $code = 0, $previous = null)
    {
        $this->resource = $resource;

        parent::__construct($message, $code, $previous);
    }

    public function getResource()
    {
        return $this->resource;
    }
}
