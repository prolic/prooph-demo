<?php

declare (strict_types=1);

namespace Prooph\Demo\ReadModel;

use PDO;
use Prooph\EventStore\Projection\AbstractReadModel;

class PostsReadModel extends AbstractReadModel
{
    /**
     * @var PDO
     */
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function init(): void
    {
        $statement = $this->connection->prepare(<<<SQL
CREATE TABLE posts (
  id char(36),
  title VARCHAR(150) NOT NULL,
  content TEXT NOT NULL,
  PRIMARY KEY (id),
  UNIQUE (id)
);
SQL
        );
        $statement->execute();
    }

    public function isInitialized(): bool
    {
        $statement = $this->connection->prepare('SELECT * FROM posts LIMIT 1');
        $statement->execute();

        if ('00000' === $statement->errorCode()) {
            return true;
        }

        return false;
    }

    public function reset(): void
    {
        $statement = $this->connection->prepare('TRUNCATE posts');
        $statement->execute();
    }

    public function delete(): void
    {
        $statement = $this->connection->prepare('DROP TABLE posts');
        $statement->execute();
    }

    protected function insert(array $data): void
    {
        $statement = $this->connection->prepare('INSERT INTO posts (id, title, content) VALUES (?, ?, ?)');
        $statement->execute([
            $data['id'],
            $data['title'],
            $data['content'],
        ]);
    }
}
