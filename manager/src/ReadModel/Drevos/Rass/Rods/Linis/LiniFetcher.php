<?php

declare(strict_types=1);

namespace App\ReadModel\Drevos\Rass\Rods\Linis;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class LiniFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }



    public function getMaxSortLinia(string $rodo): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(l.sort_lini) AS m')
            ->from('dre_ras_rod_linis', 'l')
			->andWhere('rodo_id = :rodos')
            ->setParameter(':rodos', $rodo)
            ->execute()->fetch()['m'];
    }


    public function allOfRodo(string $rodo): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'l.id',
                'l.rodo_id',
                'l.name',
                'l.sort_lini',
                '(SELECT COUNT(*) FROM dre_ras_rod_lini_wets w WHERE w.linia_id = l.id) AS wetkas'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('dre_ras_rod_linis', 'l')
            ->andWhere('rodo_id = :rodos ')
            ->setParameter(':rodos', $rodo)
            ->orderBy('sort_lini')
            ->orderBy('l.name')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
		
	public function allOfRasLin(string $rodo): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'l.id',
                'l.name',
				'l.sort_lini'

                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('dre_ras_rod_linis', 'l')
            ->andWhere('rodo_id = :rodos')
            ->setParameter(':rodos', $rodo)
//            ->innerJoin('l', 'rod_rasa_rodo_linia_nomers', 'n', 'n.linia_id = l.id')
            ->orderBy('sort_lini')
            ->orderBy('name')

            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
	

    }