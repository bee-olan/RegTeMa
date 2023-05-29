<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Rasas\Linias;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class LiniaFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function allOfVetka(string $linia, string $name_star): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'l.id',
                'l.name',
                'l.name_star',
                'l.title',
                'l.id_vetka',
                'l.sort_linia',
                'l.vetka_id',
                '(SELECT COUNT(*) FROM adminka_rasa_linia_nomers n WHERE n.linia_id = l.id) AS nomers'
            // '(
            //     SELECT COUNT(ms.member_id)
            //     FROM work_projects_project_memberships ms
            //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
            //     WHERE md.department_id = d.id AND ms.materi_id = :materi
            // ) AS members_count'
            )
            ->from('adminka_rasa_linias', 'l')
            ->andWhere('vetka_id = :linias AND  l.name_star = :stname')
            ->setParameter(':linias', $linia)
            ->setParameter(':stname', $name_star)
//            ->orderBy('name')
            ->orderBy('l.name_star')
//            ->orderBy('title')
//			->orderBy('sort_linia')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function getMaxSortLinia(string $rasa): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(l.sort_linia) AS m')
            ->from('adminka_rasa_linias', 'l')
			->andWhere('rasa_id = :rasas')
            ->setParameter(':rasas', $rasa)
            ->execute()->fetch()['m'];
    }
	
    public function listOfRasa(string $rasa): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
//                'rasa_id',
//                'name',
//                'name_star',
//                'title',
                'id_vetka'
//				'sort_linia',
//                'vetka_id'
            )
            ->from('adminka_rasa_linias')
            ->andWhere('rasa_id = :rasas')
            ->setParameter(':rasas', $rasa)
//            ->orderBy('name')
            ->orderBy('name_star')
//            ->orderBy('title')
//			->orderBy('sort_linia')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function allOfRasa(string $rasa): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'l.id',
                'l.name',
                'l.name_star',
                'l.title',
                'l.id_vetka',
                'l.sort_linia',
                'l.vetka_id',
                '(SELECT COUNT(*) FROM adminka_rasa_linia_nomers n WHERE n.linia_id = l.id) AS nomers'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('adminka_rasa_linias', 'l')
            ->andWhere('rasa_id = :rasas AND  l.vetka_id IS NULL')
            ->setParameter(':rasas', $rasa)
//            ->orderBy('name')
            ->orderBy('l.name_star')
//            ->orderBy('title')
//			->orderBy('sort_linia')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
		
	public function allOfRasLin(string $rasa): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'l.id',
                'l.name',
                'l.name_star',
                'l.title',
                'l.id_vetka',
				'l.sort_linia',
                'l.vetka_id',
				'n.sort_nomer as sort_nomer',
				'n.name_star as nomers',
				'n.name_star as nomers'

                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('adminka_rasa_linias', 'l')
            ->andWhere('rasa_id = :rasas')
            ->setParameter(':rasas', $rasa)
->innerJoin('l', 'adminka_rasa_linia_nomers', 'n', 'n.linia_id = l.id')
//            ->orderBy('name')
            ->orderBy('name_star')
//            ->orderBy('title')
			->orderBy('sort_linia')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
	

    }