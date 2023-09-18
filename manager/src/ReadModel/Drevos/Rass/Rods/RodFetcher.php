<?php

declare(strict_types=1);

namespace App\ReadModel\Drevos\Rass\Rods;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class RodFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'd.id',
                'd.rasa_id',
                'd.sort_rodo',
                'd.name_matkov',
                'd.kod_matkov',
                'd.strana_id',
                'r.name as rasa',
                's.name as strana'
            )
            ->from('dre_ras_rods','d')
            ->innerJoin('d', 'dre_rass', 'r', 'r.id = rasa_id')
            ->innerJoin('d', 'dre_strans', 's', 's.id = d.strana_id')
            ->orderBy('sort_rodo')


            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function getMaxSortRodo(string $rasa): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(l.sort_rodo) AS m')
            ->from('dre_ras_rods', 'l')
			->andWhere('rasa_id = :rasas')
            ->setParameter(':rasas', $rasa)
            ->execute()->fetch()['m'];
    }

    public function allOfRasa(string $rasa): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'l.id',
                'l.rasa_id',
                'l.sort_rodo',
                'l.name_matkov',
                'l.kod_matkov',
                'l.strana_id',
                's.name as strana',
                's.nomer as str_nom',
                '(SELECT COUNT(*) FROM dre_ras_rod_linis n WHERE n.rodo_id = l.id) AS linias'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('dre_ras_rods', 'l')
            ->innerJoin('l', 'dre_strans', 's', 's.id = l.strana_id')
            ->andWhere('rasa_id = :rasas ')
            ->setParameter(':rasas', $rasa)
            ->orderBy('l.sort_rodo')

            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
		
//	public function allOfRasRodo(string $rasa): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'l.id',
//                'l.name_mat',
//                'l.name_ot',
//                'l.name_lin',
//                'l.name_nom',
//                'l.name_god',
//				'l.sort_rodo',
//                'l.strana_id'
//
//
//                // '(
//                //     SELECT COUNT(ms.member_id)
//                //     FROM work_projects_project_memberships ms
//                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
//                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
//                // ) AS members_count'
//            )
//            ->from('rod_rasa_rodos', 'l')
//            ->andWhere('rasa_id = :rasas')
//            ->setParameter(':rasas', $rasa)
////            ->innerJoin('l', 'rod_rasa_rodo_linias', 'n', 'n.rodo_id = l.id')
//            ->orderBy('name_mat')
//			->orderBy('sort_rodo')
//            ->execute();
//
//            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//        }
	

    }