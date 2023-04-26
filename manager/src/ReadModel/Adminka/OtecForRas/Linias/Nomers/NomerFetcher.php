<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\OtecForRas\Linias\Nomers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class NomerFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


//    public function listOfLinia(string $linia): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'id',
//                'name',
//                'name_star',
//                'title',
//                'sort_nomer'
//            )
//            ->from('adminka_rasa_linia_nomers')
//            ->andWhere('linia_id = :linia')
//            ->setParameter(':linia', $linia)
//            ->orderBy('name')
//            ->orderBy('name_star')
//            ->orderBy('title')
//            ->orderBy('sort_nomer')
//            ->execute();
//
//        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
//    }

    public function allOfLinia(string $linia): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'd.id',
                'd.name',
                'TRIM(CONCAT(d.matka_linia, \' \',d.matka_nomer )) AS matka',
                'TRIM(CONCAT(d.otec_linia, \' \', d.otec_nomer )) AS otec',
                'd.title',
                'd.oblet'
            )
            ->from('adminka_otec_ras_linia_nomers', 'd')
            ->andWhere('linia_id = :linia')
            ->setParameter(':linia', $linia)
            ->orderBy('name')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }

    }