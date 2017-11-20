<?php

declare(strict_types=1);

namespace Prooph\Demo\Model;

interface PostCollection
{
    public function save(Post $post): void;

    public function get(PostId $postId): ?Post;
}
