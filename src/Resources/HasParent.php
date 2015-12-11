<?php

namespace gamringer\PHPREST\Resources;

interface HasParent
{
    public function setParent($parent);
    
    public function getParent();
}
