<?php

declare(strict_types=1);

namespace Prooph\Demo;

use Zend\Expressive;
use Zend\View;

return [
    'dependencies' => [
        'factories' => [
            Expressive\Template\TemplateRendererInterface::class => Expressive\ZendView\ZendViewRendererFactory::class,
            View\HelperPluginManager::class => Expressive\ZendView\HelperPluginManagerFactory::class,
        ],
    ],
    'templates' => [
        'layout' => 'app::layout',
        'map' => [
            'error::error' => 'templates/error/error.phtml',
            'error::404' => 'templates/error/404.phtml',
            //html templates
            'app::layout' => 'templates/layout/layout.phtml',
            'page::post-list' => 'templates/action/post-list.phtml',
            'page::create-post' => 'templates/action/create-post.phtml',
        ],
    ],
];
