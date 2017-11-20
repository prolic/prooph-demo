<?php

declare(strict_types=1);

namespace Prooph\Demo;

use Prooph\Demo\Container\Model\CreatePostHandlerFactory;
use Prooph\Demo\Container\ReadModel\Finder\PostsFinderFactory;
use Prooph\Demo\Infrastructure\CommandFactory;
use Prooph\Demo\Infrastructure\EventFactory;
use Prooph\Demo\Infrastructure\EventStorePostCollection;
use Prooph\Demo\Model\Handler\CreatePostHandler;
use Prooph\Demo\Model\Post;
use Prooph\Demo\Model\PostCollection;
use Prooph\Demo\ReadModel\Finder\PostsFinder;
use Prooph\Demo\Response\JsonResponse;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventSourcing\Container\Aggregate\AggregateRepositoryFactory;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Pdo\Container\PdoConnectionFactory;
use Prooph\EventStore\Pdo\Container\PostgresEventStoreFactory;
use Prooph\EventStore\Pdo\Container\PostgresProjectionManagerFactory;
use Prooph\EventStore\Pdo\PersistenceStrategy\PostgresAggregateStreamStrategy;
use Prooph\EventStore\Projection\ProjectionManager;
use Prooph\EventStoreBusBridge\Container\TransactionManagerFactory;
use Prooph\EventStoreBusBridge\TransactionManager;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\Container\CommandBusFactory;
use Prooph\ServiceBus\Container\QueryBusFactory;
use Prooph\ServiceBus\Plugin\InvokeStrategy\FinderInvokeStrategy;
use Prooph\ServiceBus\QueryBus;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'prooph' => [
        'event_store' => [
            'default' => [
                'connection' => 'pdo.connection',
                'message_factory' => EventFactory::class,
                'persistence_strategy' => PostgresAggregateStreamStrategy::class,
            ],
        ],
        'event_sourcing' => [
            'aggregate_repository' => [
                'post_collection' => [
                    'repository_class' => EventStorePostCollection::class,
                    'aggregate_type' => [
                        'post' => Post::class,
                    ],
                    'aggregate_translator' => AggregateTranslator::class,
                    'stream_name' => 'post',
                    'one_stream_per_aggregate' => true,
                ],
            ],
        ],
        'middleware' => [
            'command' => [
                'response_strategy' => JsonResponse::class,
                'message_factory' => CommandFactory::class,
            ],
        ],
        'service_bus' => [
            'command_bus' => [
                'router' => [
                    'routes' => [
                        'create-post' => CreatePostHandler::class,
                    ],
                ],
                'plugins' => [
                    TransactionManager::class,
                ],
            ],
            'query_bus' => [
                'router' => [
                    'routes' => [
                        'fetch-posts' => PostsFinder::class,
                    ],
                ],
                'plugins' => [
                    FinderInvokeStrategy::class,
                ]
            ]
        ],
        'projection_manager' => [
            'default' => [
                'connection' => 'pdo.connection',
            ],
        ],
        'pdo_connection' => [
            'default' => [
                'schema' => 'pgsql',
                'user' => 'postgres',
                'dbname' => 'prooph_demo',
                'password' => 'postgres',
                'port' => 5432,
            ],
        ],
    ],
    'dependencies' => [
        'factories' => [
            'pdo.connection' => PdoConnectionFactory::class,
            AggregateTranslator::class => InvokableFactory::class,
            CommandFactory::class => InvokableFactory::class,
            CommandBus::class => CommandBusFactory::class,
            EventStore::class => PostgresEventStoreFactory::class,
            PostCollection::class => [AggregateRepositoryFactory::class, 'post_collection'],
            CreatePostHandler::class => CreatePostHandlerFactory::class,
            EventFactory::class => InvokableFactory::class,
            FinderInvokeStrategy::class => InvokableFactory::class,
            PostgresAggregateStreamStrategy::class => InvokableFactory::class,
            PostsFinder::class => PostsFinderFactory::class,
            ProjectionManager::class => PostgresProjectionManagerFactory::class,
            QueryBus::class => QueryBusFactory::class,
            \Prooph\Psr7Middleware\CommandMiddleware::class => \Prooph\Psr7Middleware\Container\CommandMiddlewareFactory::class,
            JsonResponse::class => InvokableFactory::class,
            TransactionManager::class => TransactionManagerFactory::class,
        ],
    ],
];