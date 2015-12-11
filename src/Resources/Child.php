<?php

namespace gamringer\PHPREST\Resources;

trait Child
{
	protected $parent;

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }
}
