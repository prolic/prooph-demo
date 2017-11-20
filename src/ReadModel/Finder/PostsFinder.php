<?php

declare (strict_types=1);

namespace Prooph\Demo\ReadModel\Finder;

use PDO;
use Prooph\Demo\ReadModel\Query\FetchPosts;
use React\Promise\Deferred;

class PostsFinder
{
    /**
     * @var PDO
     */
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function find(FetchPosts $query, Deferred $deferred): void
    {
        $statement = $this->connection->prepare('SELECT * FROM posts');
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $deferred->resolve($results);
    }
}
