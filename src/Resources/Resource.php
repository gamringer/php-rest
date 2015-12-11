<?php

namespace gamringer\PHPREST\Resources;

abstract class Resource implements HasParent
{
    use Child;

    protected $filters = [];

    public function get()
    {
        
    }

    public function put()
    {
        
    }

    public function delete()
    {
        
    }

    public function patch()
    {
        
    }

    public function head()
    {
        
    }

    public function options()
    {
        
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
