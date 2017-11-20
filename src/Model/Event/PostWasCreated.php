<?php

declare(strict_types=1);

namespace Prooph\Demo\Model\Event;

use Prooph\Demo\Model\Content;
use Prooph\Demo\Model\PostId;
use Prooph\Demo\Model\Title;
use Prooph\EventSourcing\AggregateChanged;

final class PostWasCreated extends AggregateChanged
{
    /**
     * @var string
     */
    protected $messageName = 'post-was-created';

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

    public static function with(PostId $postId, Title $title, Content $content): PostWasCreated
    {
        $event = self::occur($postId->__toString(), [
            'title' => $title->__toString(),
            'content' => $content->__toString(),
        ]);

        $event->postId = $postId;
        $event->title = $title;
        $event->content = $content;

        return $event;
    }

    /**
     * @return PostId
     */
    public function postId(): PostId
    {
        if (null === $this->postId) {
            $this->postId = PostId::fromString($this->aggregateId());
        }

        return $this->postId;
    }

    /**
     * @return Title
     */
    public function title(): Title
    {
        if (null === $this->title) {
            $this->title = Title::fromString($this->payload()['title']);
        }

        return $this->title;
    }

    /**
     * @return Content
     */
    public function content(): Content
    {
        if (null === $this->content) {
            $this->content = Content::fromString($this->payload()['content']);
        }

        return $this->content;
    }
}
