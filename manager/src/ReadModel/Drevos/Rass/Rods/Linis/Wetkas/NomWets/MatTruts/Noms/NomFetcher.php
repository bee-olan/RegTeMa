<?php

declare(strict_types=1);

namespace App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class NomFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }



    public function getMaxSortNom(string $mattrut): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(w.sort_nom) AS m')
            ->from('dre_ras_rod_lini_wet_nomw_noms', 'w')
			->andWhere('mattrut_id = :mattruts')
            ->setParameter(':mattruts', $mattrut)
            ->execute()->fetch()['m'];
    }


    public function allOfMatTrut(string $mattrut): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'w.id',
                'w.mattrut_id',
                'w.nom',
                'w.god',
                'w.tit',
                'w.status',
//                'w.name_ot',
                'w.sort_nom',
                'w.zakazal_id',
                'TRIM(CONCAT(u.name_first, \' \', u.name_last, \'  - \', u.nike)) AS nike'
//                '(SELECT COUNT(*) FROM rod_rasa_rodo_mattrut_nomers n WHERE n.mattrut_id = w.id) AS nomers'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('dre_ras_rod_lini_wet_nomw_noms', 'w')
            ->innerJoin('w', 'admin_uchasties_uchasties', 'u', 'w.zakazal_id = u.id')
            ->andWhere('mattrut_id = :mattruts ')
            ->setParameter(':mattruts', $mattrut)
            ->orderBy('sort_nom')
            ->orderBy('w.nom')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }


    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'w.id',
                'w.mattrut_id',
                'w.nom',
                'w.god',
                'w.tit',
//                'w.name_ot',
                'w.sort_nom',
                'w.status',
                'w.zakazal_id',
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
                'ra.name AS rasa',
                'TRIM(CONCAT(u.name_first, \' \', u.name_last, \'  - \', u.nike)) AS nike'


            )
            ->from('dre_ras_rod_lini_wet_nomw_noms', 'w')
            ->innerJoin('w', 'dre_ras_rod_lini_wet_nomws', 'n', 'w.mattrut_id = n.id')
            ->innerJoin('n', 'dre_ras_rod_lini_wets', 'we', 'n.wetka_id = we.id')
            ->innerJoin('we', 'dre_ras_rod_linis', 'l', 'we.linia_id = l.id')
            ->innerJoin('l', 'dre_ras_rods', 'r', 'l.rodo_id = r.id')
            ->innerJoin('r', 'dre_strans', 's', 'r.strana_id = s.id')
            ->innerJoin('r', 'dre_rass', 'ra', 'r.rasa_id = ra.id')
            ->innerJoin('w', 'admin_uchasties_uchasties', 'u', 'w.zakazal_id = u.id')
            ->orderBy('sort_nom')
            ->orderBy('sort_nom_wet')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

}