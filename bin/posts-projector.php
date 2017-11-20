<?php

declare (strict_types=1);

namespace Prooph\Demo;

use Prooph\Demo\Model\Event\PostWasCreated;
use Prooph\Demo\ReadModel\PostsReadModel;
use Prooph\EventStore\Projection\ProjectionManager;

error_reporting(E_ALL & ~E_NOTICE);
chdir(dirname(__DIR__));

require 'vendor/autoload.php';

$container = require 'config/container.php';

$projectionManager = $container->get(ProjectionManager::class);
/* @var ProjectionManager $projectionManager */

$readModel = new PostsReadModel($container->get('pdo.connection'));
$projection = $projectionManager->createReadModelProjection('posts', $readModel);
$projection
    ->fromCategory('post')
    ->when([
        'post-was-created' => function ($state, PostWasCreated $event) {
            $this->readModel()->stack('insert', [
                'id' => $event->postId()->__toString(),
                'title' => $event->title()->__toString(),
                'content' => $event->content()->__toString(),
            ]);
        },
    ])
    ->run();