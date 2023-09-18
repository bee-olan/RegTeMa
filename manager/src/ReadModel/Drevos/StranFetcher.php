<?php

declare(strict_types=1);

namespace App\ReadModel\Drevos;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class StranFetcher
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
            ->from('dre_strans')
            ->orderBy('nomer')
            ->execute();

            return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'g.id',
                'g.name',
                'g.nomer',
                '(SELECT COUNT(*) FROM dre_ras_rods r WHERE r.strana_id = g.id) AS rodosl'
            )
            ->from('dre_strans', 'g')
            ->orderBy('nomer')

            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}
