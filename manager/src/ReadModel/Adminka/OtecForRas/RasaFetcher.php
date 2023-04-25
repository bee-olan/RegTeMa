<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\OtecForRas;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class RasaFetcher
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
            ->from('adminka_rasas')
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
                '(SELECT COUNT(*) FROM adminka_otec_ras_linias l WHERE l.rasa_id = g.id) AS linias'
            )
            ->from('adminka_otec_ras', 'g')
            ->orderBy('name')
            ->orderBy('title')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

//    public function allRasaLin(): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'r.id',
//                'r.name',
//                'r.title',
//                'l.sort_linia as sort_linia',
//                'l.name_star as linias',
//                'l.id as linia_id'
//                //,
//                // '(SELECT COUNT(*) FROM adminka_rasa_linias l WHERE l.rasa_id = r.id) AS kol_lin'
//            )
//            ->from('rabota_rasas', 'r')
//            ->innerJoin('r', 'adminka_rasa_linias', 'l', 'l.rasa_id = r.id')
//            ->orderBy('name')
//            ->orderBy('title')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }

//    public function allRasaLinNom(): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'r.id',
//                'r.name',
//                'r.title',
//                'l.sort_linia as sort_linia',
//                'l.name_star as linias',
//                'l.id as linia_id',
//                'n.sort_nomer as sort_nomer',
//                'n.name_star as nomers',
//                'n.id as nomer_id',
//                'n.title as nomer_title'
//            )
//            ->from('adminka_rasas', 'r')
//            ->innerJoin('r', 'adminka_rasa_linias', 'l', 'l.rasa_id = r.id')
//            ->innerJoin('l', 'adminka_rasa_linia_nomers', 'n', 'n.linia_id = l.id')
//            ->orderBy('sort_linia')
//            ->orderBy('title')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }
}
