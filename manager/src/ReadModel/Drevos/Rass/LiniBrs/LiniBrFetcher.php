<?php

declare(strict_types=1);

namespace App\ReadModel\Drevos\Rass\LiniBrs;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class LiniBrFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

//    public function allOfVetka(string $linia, string $name_star): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'l.id',
//                'l.name',
//                'l.sort_lini_br'
////                '(SELECT COUNT(*) FROM adminka_rasa_linia_nomers n WHERE n.linia_id = l.id) AS nomers'
//            // '(
//            //     SELECT COUNT(ms.member_id)
//            //     FROM work_projects_project_memberships ms
//            //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
//            //     WHERE md.department_id = d.id AND ms.materi_id = :materi
//            // ) AS members_count'
//            )
//            ->from('dre_ras_linibrs', 'l')
//            ->andWhere('vetka_id = :linias AND  l.name_star = :stname')
//            ->setParameter(':linias', $linia)
//            ->setParameter(':stname', $name_star)
////            ->orderBy('name')
//            ->orderBy('l.sort_lini_br')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }

    public function getMaxSortLiniBr(string $rasa): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(l.sort_lini_br) AS m')
            ->from('dre_ras_linibrs', 'l')
			->andWhere('rasa_id = :rasas')
            ->setParameter(':rasas', $rasa)
            ->execute()->fetch()['m'];
    }
	
//    public function listOfRasa(string $rasa): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'id',
////                'rasa_id',
////                'name',
////                'name_star',
////                'title',
//                'id_vetka'
////				'sort_linia',
////                'vetka_id'
//            )
//            ->from('adminka_rasa_linias')
//            ->andWhere('rasa_id = :rasas')
//            ->setParameter(':rasas', $rasa)
////            ->orderBy('name')
//            ->orderBy('name_star')
////            ->orderBy('title')
////			->orderBy('sort_linia')
//            ->execute();
//
//        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
//    }

    public function allOfRas(string $rasa): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'l.id',
                'l.rasa_id',
                'l.vetka_id',
                'l.name',
                'l.sort_lini_br'
//                '(SELECT COUNT(*) FROM adminka_rasa_linia_nomers n WHERE n.linia_id = l.id) AS nomers'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('dre_ras_linibrs', 'l')
            ->andWhere('rasa_id = :rasas')
            ->setParameter(':rasas', $rasa)
            ->orderBy('l.sort_lini_br')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
		
	public function allOfRasLin(string $rasa): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'l.id',
                'l.rasa_id',
                'l.vetka_id',
                'l.name',
				'l.sort_lini_br'
//				'n.sort_nomer as sort_nomer',
//				'n.name_star as nomers',
//				'n.name_star as nomers'

                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('dre_ras_linibrs', 'l')
            ->andWhere('rasa_id = :rasas')
            ->setParameter(':rasas', $rasa)
//            ->innerJoin('l', 'adminka_rasa_linia_nomers', 'n', 'n.linia_id = l.id')

			->orderBy('sort_lini_br')
            ->orderBy('name')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
	

    }