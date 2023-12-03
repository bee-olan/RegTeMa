<?php

declare(strict_types=1);

namespace App\ReadModel\Drevos\Rass\LiniBrs\VetkaBrs;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class VetkaBrFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

//    public function allOfVetka(string $vetka, string $name_star): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'l.id',
//                'l.name',
//                'l.sort_vet'
////                '(SELECT COUNT(*) FROM adminka_vetka_vetka_nomers n WHERE n.vetka_id = l.id) AS nomers'
//            // '(
//            //     SELECT COUNT(ms.member_id)
//            //     FROM work_projects_project_memberships ms
//            //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
//            //     WHERE md.department_id = d.id AND ms.materi_id = :materi
//            // ) AS members_count'
//            )
//            ->from('dre_ras_linibrs', 'l')
//            ->andWhere('vetka_id = :vetkas AND  l.name_star = :stname')
//            ->setParameter(':vetkas', $vetka)
//            ->setParameter(':stname', $name_star)
////            ->orderBy('name')
//            ->orderBy('l.sort_vet')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }

    public function getMaxSortVet(string $linia): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(l.sort_vet) AS m')
            ->from('dre_ras_linibr_vets', 'l')
			->andWhere('linia_id = :linias')
            ->setParameter(':linias', $linia)
            ->execute()->fetch()['m'];
    }
	
//    public function listOfRasa(string $vetka): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'id',
////                'vetka_id',
////                'name',
////                'name_star',
////                'title',
//                'id_vetka'
////				'sort_vetka',
////                'vetka_id'
//            )
//            ->from('adminka_vetka_vetkas')
//            ->andWhere('vetka_id = :vetkas')
//            ->setParameter(':vetkas', $vetka)
////            ->orderBy('name')
//            ->orderBy('name_star')
////            ->orderBy('title')
////			->orderBy('sort_vetka')
//            ->execute();
//
//        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
//    }

    public function allOfLiniBr(string $linia): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'l.id',
                'l.linia_id',
                'l.nomer',
                'l.god',
                'l.sort_vet',
                '(SELECT COUNT(*) FROM dre_ras_linibr_vet_noms n WHERE n.vetka_id = l.id) AS kol_nombr'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('dre_ras_linibr_vets', 'l')
            ->andWhere('linia_id = :linias')
            ->setParameter(':linias', $linia)
            ->orderBy('l.sort_vet')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
		
	public function allOfLinVet(string $linia): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'l.id',
                'l.linia_id',
                'l.nomer',
                'l.god',
				'l.sort_vet'

                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('dre_ras_linibr_vets', 'l')
            ->andWhere('vetka_id = :vetkas')
            ->setParameter(':vetkas', $vetka)
//            ->innerJoin('l', 'adminka_vetka_vetka_nomers', 'n', 'n.vetka_id = l.id')

			->orderBy('sort_vet')
            ->orderBy('nomer')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
	

    }