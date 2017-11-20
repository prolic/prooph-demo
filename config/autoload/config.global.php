<?php

declare(strict_types=1);

namespace Prooph\Demo;

use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Container\ErrorHandlerFactory;
use Zend\Expressive\Container\ErrorResponseGeneratorFactory;
use Zend\Expressive\Container\NotFoundDelegateFactory;
use Zend\Expressive\Container\NotFoundHandlerFactory;
use Zend\Expressive\Delegate\NotFoundDelegate;
use Zend\Expressive\Helper;
use Zend\Expressive\Middleware\ErrorResponseGenerator;
use Zend\Expressive\Middleware\NotFoundHandler;
use Zend\Expressive\Router;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Stratigility\Middleware\ErrorHandler;
use Zend\Stratigility\Middleware\OriginalMessages;

return [
    'debug' => true,
    'config_cache_enabled' => false,
    'zend-expressive' => [
        'error_handler' => [
            'template_404' => 'error::404',
            'template_error' => 'error::error',
        ],
        'programmatic_pipeline' => true,
        'raise_throwables' => true,
    ],
    'dependencies' => [
        'aliases' => [
            'Zend\Expressive\Delegate\DefaultDelegate' => NotFoundDelegate::class,
            Router\RouterInterface::class => Router\AuraRouter::class,
        ],
        'factories' => [
            // Application
            Application::class => ApplicationFactory::class,
            ErrorHandler::class => ErrorHandlerFactory::class,
            ErrorResponseGenerator::class => ErrorResponseGeneratorFactory::class,
            Router\AuraRouter::class => InvokableFactory::class,
            Helper\UrlHelper::class => Helper\UrlHelperFactory::class,
            Helper\ServerUrlHelper::class => InvokableFactory::class,
            Helper\ServerUrlMiddleware::class => Helper\ServerUrlMiddlewareFactory::class,
            Helper\UrlHelperMiddleware::class => Helper\UrlHelperMiddlewareFactory::class,
            Middleware\JsonPayload::class => InvokableFactory::class,
            NotFoundDelegate::class => NotFoundDelegateFactory::class,
            NotFoundHandler::class => NotFoundHandlerFactory::class,
            OriginalMessages::class => InvokableFactory::class,
            // Action middleware
            App\Action\PostList::class => Container\App\Action\PostListFactory::class,
            App\Action\CreatePost::class => Container\App\Action\CreatePostFactory::class,
        ],
    ],
];
