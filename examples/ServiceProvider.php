<?php

namespace gamringer\PHPREST\Example;

use League\Container\ServiceProvider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'controller-author_item',
    ];

    public function register()
    {
        $container = $this->getContainer();
        
        $container->share('controller-author_item', 'gamringer\PHPREST\Example\Controllers\AuthorController');
    }
}