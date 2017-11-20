<?php

declare(strict_types=1);

namespace Prooph\Demo\Infrastructure;

use Prooph\Demo\Model\Post;
use Prooph\Demo\Model\PostCollection;
use Prooph\Demo\Model\PostId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;

final class EventStorePostCollection extends AggregateRepository implements PostCollection
{
    public function save(Post $post): void
    {
        $this->saveAggregateRoot($post);
    }

    public function get(PostId $postId): ?Post
    {
        return $this->getAggregateRoot($postId->__toString());
    }
}
