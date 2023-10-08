<?php

declare(strict_types=1);

namespace App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\NomWets\MatTruts;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class MatTrutFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }



    public function getMaxSortTrut(string $nomwet): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(w.sort_trut) AS m')
            ->from('dre_ras_rod_lini_wet_nomw_truts', 'w')
			->andWhere('nomwet_id = :nomwets')
            ->setParameter(':nomwets', $nomwet)
            ->execute()->fetch()['m'];
    }


    public function allOfNomWet(string $nomwet): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'w.id',
                'w.nomwet_id',
                'w.name_ot',
                'w.sort_trut',
                '(SELECT COUNT(*) FROM dre_ras_rod_lini_wet_nomw_noms n WHERE n.mattrut_id = w.id) AS nomers'
            )
            ->from('dre_ras_rod_lini_wet_nomw_truts', 'w')
            ->andWhere('nomwet_id = :nomwets ')
            ->setParameter(':nomwets', $nomwet)
            ->orderBy('sort_trut')

            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }


    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'w.id',
                'w.nomwet_id',
                'w.name_ot',
                'w.sort_trut',
                'n.tit_w',
                'n.wetka_id',
                'we.name_w',
                'we.linia_id',
                'l.name',
                'l.rodo_id',
                'r.name_matkov AS name_m',
                'r.kod_matkov AS kod_m',
                'r.rasa_id',
                's.name AS strana',
                'ra.name AS rasa'

            )
            ->from('dre_ras_rod_lini_wet_nomw_truts', 'w')
            ->innerJoin('w', 'dre_ras_rod_lini_wet_nomws', 'n', 'w.nomwet_id = n.id')
            ->innerJoin('n', 'dre_ras_rod_lini_wets', 'we', 'n.wetka_id = we.id')
            ->innerJoin('we', 'dre_ras_rod_linis', 'l', 'we.linia_id = l.id')
            ->innerJoin('l', 'dre_ras_rods', 'r', 'l.rodo_id = r.id')
            ->innerJoin('r', 'dre_strans', 's', 'r.strana_id = s.id')
            ->innerJoin('r', 'dre_rass', 'ra', 'r.rasa_id = ra.id')
            ->orderBy('sort_trut')
            ->orderBy('sort_nom_wet')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

}