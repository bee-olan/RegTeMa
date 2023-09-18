<?php

declare(strict_types=1);

namespace App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class WetkaFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }



    public function getMaxSortWetka(string $linia): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(w.sort_wetka) AS m')
            ->from('dre_ras_rod_lini_wets', 'w')
			->andWhere('linia_id = :linias')
            ->setParameter(':linias', $linia)
            ->execute()->fetch()['m'];
    }


    public function allOfLinia(string $linia): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'w.id',
                'w.linia_id',
                'w.name_w',
                'w.sort_wetka',
               '(SELECT COUNT(*) FROM dre_ras_rod_lini_wet_nomws n WHERE n.wetka_id = w.id) AS nomwets'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('dre_ras_rod_lini_wets', 'w')
            ->andWhere('linia_id = :linias ')
            ->setParameter(':linias', $linia)
            ->orderBy('sort_wetka')
            ->orderBy('w.name_w')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
		
//	public function allOfRasLin(string $linia): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'w.id',
//                'w.name',
////                'w.name_star',
////                'w.title',
//				'w.sort_lini'
////				'n.sort_nomer as sort_nomer'
//
//
//                // '(
//                //     SELECT COUNT(ms.member_id)
//                //     FROM work_projects_project_memberships ms
//                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
//                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
//                // ) AS members_count'
//            )
//            ->from('dre_ras_rod_linis', 'l')
//            ->andWhere('linia_id = :linias')
//            ->setParameter(':linias', $linia)
////            ->innerJoin('l', 'rod_rasa_rodo_linia_nomers', 'n', 'n.linia_id = w.id')
//            ->orderBy('sort_lini')
//            ->orderBy('name')
//
//            ->execute();
//
//            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//        }
	

    }