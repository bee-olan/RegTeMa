<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Rasas\Linias;


//use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;

use App\Model\Adminka\Entity\Rasas\Rasa;
use App\ReadModel\Comment\CommentRow;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class CommentLiniaFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function allForLinia(string $id): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'c.id',
                'c.date',
                'm.id AS author_id',
                'TRIM(CONCAT(m.name_first, \' \', m.name_last)) AS author_name',
                'm.email AS author_email',
                'u.nike as author_nike',
                'c.text'
            )
            ->from('comment_comments', 'c')
            ->innerJoin('c', 'admin_uchasties_uchasties', 'u', 'c.author_id = u.id')
            ->innerJoin('c', 'user_users', 'm', 'c.author_id = m.id')
            ->andWhere('c.entity_type = :entity_type AND c.entity_id = :entity_id')
            ->setParameter(':entity_type', Rasa::class)
            ->setParameter(':entity_id', $id)
            ->orderBy('c.date')
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, CommentRow::class);

        return $stmt->fetchAll();
    }
}