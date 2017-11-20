<?php

declare(strict_types=1);

namespace Prooph\Demo\Model;

use Prooph\Demo\Model\Event\PostWasCreated;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

final class Post extends AggregateRoot
{
    /**
     * @var PostId
     */
    private $postId;

    /**
     * @var Title
     */
    private $title;

    /**
     * @var Content
     */
    private $content;

    public static function create(PostId $postId, Title $title, Content $content): Post
    {
        $post = new Post();

        $post->recordThat(PostWasCreated::with($postId, $title, $content));

        return $post;
    }

    /**
     * @return PostId
     */
    public function postId(): PostId
    {
        return $this->postId;
    }

    /**
     * @return Title
     */
    public function title(): Title
    {
        return $this->title;
    }

    /**
     * @return Content
     */
    public function content(): Content
    {
        return $this->content;
    }

    protected function aggregateId(): string
    {
        return $this->postId->__toString();
    }

    protected function apply(AggregateChanged $event): void
    {
        if ($event instanceof PostWasCreated) {
            $this->postId = $event->postId();
            $this->title = $event->title();
            $this->content = $event->content();
        } else {
            throw new \RuntimeException('Invalid event given');
        }
    }
}
