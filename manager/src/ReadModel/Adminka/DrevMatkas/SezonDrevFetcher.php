<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\DrevMatkas;;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class SezonDrevFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

//    public function allPlemSezon(string $plemmatka, string $sezon): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'd.id',
//                'd.plemmatka_id',
//                'd.name'
//            )
//            ->from('admin_matkas_plemmatka_departments', 'd')
//            ->andWhere('d.plemmatka_id = :plemmatka AND d.name = :sezon')
//            ->setParameter(':plemmatka', $plemmatka)
//            ->setParameter(':sezon', $sezon)
//            ->orderBy('d.name')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }


    public function listOfDrevMatka(string $plemmatka): array
    {

        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'
            )
            ->from('adm_drev_sezondrevs')
            ->andWhere('plemmatka_id = :plemmatka')
            ->setParameter(':plemmatka', $plemmatka)
            ->orderBy('name')
            ->execute();
        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

// посчитать вручнкю всех участников этого проекта

    public function allOfDrevMatka(string $plemmatka): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'd.id',
                'd.name'
//                '(
//                    SELECT COUNT(ms.uchastie_id)
//                    FROM adminka_matkas_plemmatka_uchastniks ms
//                    INNER JOIN adminka_matkas_plemmatka_uchastnik_departments md ON ms.id = md.uchastnik_id
//                    WHERE md.department_id = d.id AND ms.plemmatka_id = :plemmatka
//                ) AS uchasties_count'
            )
            ->from('adm_drev_sezondrevs', 'd')
            ->andWhere('plemmatka_id = :plemmatka')
            ->setParameter(':plemmatka', $plemmatka)
            ->orderBy('name')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

//    public function allOfUchastie(string $uchastie): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'p.id AS plemmatka_id',
//                'p.name AS plemmatka_name',
//                'd.id AS department_id',
//                'd.name AS department_name'
//            )
//            ->from('adminka_matkas_plemmatka_uchastniks', 'ms')
//            ->innerJoin('ms', 'adminka_matkas_plemmatka_uchastnik_departments', 'msd', 'ms.id = msd.uchastnik_id')
//            ->innerJoin('msd', 'admin_matkas_plemmatka_departments', 'd', 'msd.department_id = d.id')
//            ->innerJoin('d', 'admin_matkas_plemmatkas', 'p', 'd.plemmatka_id = p.id')
//            ->andWhere('ms.uchastie_id = :uchastie')
//            ->setParameter(':uchastie', $uchastie)
//            ->orderBy('p.sort')->addOrderBy('d.name')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }
//
//    public function allOfUchastnik(string $uchastie): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'p.id AS plemmatka_id',
//                'p.name AS plemmatka_name',
//                'd.id AS department_id',
//                'd.name AS department_name'
//            )
//         //   ->from('admin_matkas_plemmatka_uchastniks', 'ms')
////            ->innerJoin('ms', 'admin_matkas_plemmatka_uchastnik_departments', 'msd', 'ms.id = msd.uchastnik_id')
//            ->innerJoin('msd', 'admin_matkas_plemmatka_departments', 'd', 'msd.department_id = d.id')
//            ->innerJoin('d', 'admin_matkas_plemmatkas', 'p', 'd.plemmatka_id = p.id')
//            ->andWhere('ms.uchastie_id = :uchastie')
//            ->setParameter(':uchastie', $uchastie)
//            ->orderBy('p.sort')->addOrderBy('d.name')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }
}
