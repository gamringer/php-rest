<?php

namespace gamringer\PHPREST\Example;

use League\Container\ServiceProvider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'controllers-author_item',
    ];

    public function register()
    {
        $container = $this->getContainer();
        
        $container->share('controllers-author_item', 'gamringer\PHPREST\Example\Controllers\AuthorController');
    }
}