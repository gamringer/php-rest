<?php

namespace gamringer\PHPREST\Resources;

interface CollectsItems
{
    public function getCollectionItem($slug);
    
    public static function getCollectionItemModel();
}
