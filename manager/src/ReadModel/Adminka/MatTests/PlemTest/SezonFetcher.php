<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\MatTests\PlemTest;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class SezonFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function listOfPlemTest(string $plemmatka): array
    {

        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'
            )
            ->from('admin_matkas_plemmatka_departments')
            ->andWhere('plemmatka_id = :plemmatka')
            ->setParameter(':plemmatka', $plemmatka)
            ->orderBy('name')
            ->execute();
        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }
// посчитать вручнкю всех участников этого проекта
    public function allOfPlemTest(string $plemtast): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'd.id',
                'd.name',
                '(
                    SELECT COUNT(ms.uchastie_id)
                    FROM adminka_matkas_plemtast_uchastniks ms
                    INNER JOIN adminka_matkas_plemtast_uchastnik_departments md ON ms.id = md.uchastnik_id
                    WHERE md.department_id = d.id AND ms.plemtast_id = :plemtast
                ) AS uchasties_count'
            )
            ->from('admin_matkas_plemtast_departments', 'd')
            ->andWhere('plemtast_id = :plemtast')
            ->setParameter(':plemtast', $plemtast)
            ->orderBy('name')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function allOfUchastie(string $uchastie): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'p.id AS plemtast_id',
                'p.name AS plemtast_name',
                'd.id AS department_id',
                'd.name AS department_name'
            )
            ->from('adminka_matkas_plemtast_uchastniks', 'ms')
            ->innerJoin('ms', 'adminka_matkas_plemtast_uchastnik_departments', 'msd', 'ms.id = msd.uchastnik_id')
            ->innerJoin('msd', 'admin_matkas_plemtast_departments', 'd', 'msd.department_id = d.id')
            ->innerJoin('d', 'admin_matkas_plemtasts', 'p', 'd.plemtast_id = p.id')
            ->andWhere('ms.uchastie_id = :uchastie')
            ->setParameter(':uchastie', $uchastie)
            ->orderBy('p.sort')->addOrderBy('d.name')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}
