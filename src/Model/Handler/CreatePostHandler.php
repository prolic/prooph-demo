<?php

declare(strict_types=1);

namespace Prooph\Demo\Model\Handler;

use Prooph\Demo\Model\Command\CreatePost;
use Prooph\Demo\Model\Post;
use Prooph\Demo\Model\PostCollection;

final class CreatePostHandler
{
    /**
     * @var PostCollection
     */
    private $postCollection;

    public function __construct(PostCollection $postCollection)
    {
        $this->postCollection = $postCollection;
    }

    public function __invoke(CreatePost $command): void
    {
        $post = Post::create($command->postId(), $command->title(), $command->content());

        $this->postCollection->save($post);
    }
}