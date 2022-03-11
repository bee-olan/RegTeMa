<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Rasas\Rasa;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class LiniaFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getMaxSortLinia(string $rasa): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(l.sort_linia) AS m')
            ->from('paseka_rasas_rasa_linias', 'l')
			->andWhere('rasa_id = :rasa')
            ->setParameter(':rasa', $rasa)
            ->execute()->fetch()['m'];
    }
    
    public function listOfRasa(string $rasa): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'
                // ,
                // 'name_star',
				// 'sort_linia'
            )
            ->from('paseka_rasas_rasa_linias')
            ->andWhere('rasa_id = :rasa')
            ->setParameter(':rasa', $rasa)
            ->orderBy('name')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function allOfRasa(string $rasa): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'd.id',
                'd.name',
                'd.name_star',
                'd.title',
				'd.sort_linia'
                // ,
                // '(
                //     SELECT COUNT(ms.pchelowod_id)
                //     FROM paseka_rasas_rasa_pcheloships ms
                //     INNER JOIN paseka_rasas_rasa_pcheloship_linias md ON ms.id = md.pcheloship_id
                //     WHERE md.linia_id = d.id AND ms.rasa_id = :rasa
                // ) AS pchelowods_count'
            )
            ->from('paseka_rasas_rasa_linias', 'd')
            ->andWhere('rasa_id = :rasa')
            ->setParameter(':rasa', $rasa)
            ->orderBy('name')
            // ->orderBy('name_star')
            // ->orderBy('sort_linia')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function allOfPchelowod(string $pchelowod): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'p.id AS rasa_id',
                'p.name AS rasa_name',
                'd.id AS linia_id',
                'd.name AS linia_name'
            )
            ->from('paseka_rasas_rasa_pcheloships', 'ms')
            ->innerJoin('ms', 'paseka_rasas_rasa_pcheloship_linias', 'msd', 'ms.id = msd.pcheloship_id')
            ->innerJoin('msd', 'paseka_rasas_rasa_linias', 'd', 'msd.linia_id = d.id')
            ->innerJoin('d', 'paseka_rasas_rasas', 'p', 'd.rasa_id = p.id')
            ->andWhere('ms.pchelowod_id = :pchelowod')
            ->setParameter(':pchelowod', $pchelowod)
            ->orderBy('p.sort')->addOrderBy('d.name')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}