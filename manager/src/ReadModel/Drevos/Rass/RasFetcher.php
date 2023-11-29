<?php

declare(strict_types=1);

namespace App\ReadModel\Drevos\Rass;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class RasFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function assoc(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'   
            )
            ->from('dre_rass')
            ->orderBy('name')
            ->execute();

            return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'g.id',
                'g.name',
                'g.title',
                '(SELECT COUNT(*) FROM dre_ras_rods r WHERE (r.rasa_id = g.id  ) ) AS rodos',
                '(SELECT COUNT(*) FROM dre_ras_linibrs l WHERE (l.rasa_id = g.id  ) ) AS kol_linis'
            )
            ->from('dre_rass', 'g')
            ->orderBy('name')
            ->orderBy('title')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

}
