<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Rasas\Rasa;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class LiniaFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getMaxSortLinia(string $rasa): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(l.sort_linia) AS m')
            ->from('paseka_rasas_rasa_linias', 'l')
			->andWhere('rasa_id = :rasa')
            ->setParameter(':rasa', $rasa)
            ->execute()->fetch()['m'];
    }
    
    public function listOfRasa(string $rasa): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name',
                'name_star',
				'sort_linia'
            )
            ->from('paseka_rasas_rasa_linias')
            ->andWhere('rasa_id = :rasa')
            ->setParameter(':rasa', $rasa)
            ->orderBy('name')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function allOfRasa(string $rasa): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'd.id',
                'd.name',
                'd.name_star',
				'd.sort_linia'
                // ,
                // '(
                //     SELECT COUNT(ms.pchelowod_id)
                //     FROM paseka_rasas_rasa_pcheloships ms
                //     INNER JOIN paseka_rasas_rasa_pcheloships_linias md ON ms.id = md.pcheloship_id
                //     WHERE md.linia_id = d.id AND ms.rasa_id = :rasa
                // ) AS pchelowods_count'
            )
            ->from('paseka_rasas_rasa_linias', 'd')
            ->andWhere('rasa_id = :rasa')
            ->setParameter(':rasa', $rasa)
            ->orderBy('name')
            ->orderBy('name_star')
            ->orderBy('sort_linia')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    // public function allOfMember(string $member): array
    // {
    //     $stmt = $this->connection->createQueryBuilder()
    //         ->select(
    //             'p.id AS project_id',
    //             'p.name AS project_name',
    //             'd.id AS department_id',
    //             'd.name AS department_name'
    //         )
    //         ->from('work_projects_project_memberships', 'ms')
    //         ->innerJoin('ms', 'work_projects_project_membership_departments', 'msd', 'ms.id = msd.membership_id')
    //         ->innerJoin('msd', 'work_projects_project_departments', 'd', 'msd.department_id = d.id')
    //         ->innerJoin('d', 'work_projects_projects', 'p', 'd.project_id = p.id')
    //         ->andWhere('ms.member_id = :member')
    //         ->setParameter(':member', $member)
    //         ->orderBy('p.sort')->addOrderBy('d.name')
    //         ->execute();

    //     return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    // }
}