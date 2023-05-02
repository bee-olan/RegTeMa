<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Rasas\Linias\Nomers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class NomerFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getMaxSortNomer(string $linia): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(n.sort_nomer) AS m')
            ->from('adminka_rasa_linia_nomers', 'n')
            ->andWhere('linia_id = :linia')
            ->setParameter(':linia', $linia)
            ->execute()->fetch()['m'];
    }

    public function listOfLinia(string $linia): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name',
                'name_star',
                'title',
                'status',
                'sort_nomer',
                'vetka_nomer'

            )
            ->from('adminka_rasa_linia_nomers')
            ->andWhere('linia_id = :linia')
            ->setParameter(':linia', $linia)
            ->orderBy('name')
            ->orderBy('name_star')
            ->orderBy('title')
            ->orderBy('sort_nomer')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function allOfLinia(string $linia): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'd.id',
                'd.name',
                'd.name_star',
                'd.title',
                'd.status',
                'd.sort_nomer',
                'd.vetka_nomer',
                '(SELECT COUNT(*) FROM adminka_rasa_linias l WHERE  l.name_star = d.name_star) AS kolvenka'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('adminka_rasa_linia_nomers', 'd')
            ->andWhere('linia_id = :linia')
            ->setParameter(':linia', $linia)
            ->orderBy('name')
            ->orderBy('name_star')
            ->orderBy('title')
            ->orderBy('sort_nomer')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
    
        // public function allOfMember(string $member): array
        // {
        //     $stmt = $this->connection->createQueryBuilder()
        //         ->select(
        //             'p.id AS materi_id',
        //             'p.name AS project_name',
        //             'd.id AS department_id',
        //             'd.name AS department_name'
        //         )
        //         ->from('work_projects_project_memberships', 'ms')
        //         ->innerJoin('ms', 'work_projects_project_membership_departments', 'msd', 'ms.id = msd.membership_id')
        //         ->innerJoin('msd', 'rabota_materis_materi_linias', 'd', 'msd.department_id = d.id')
        //         ->innerJoin('d', 'work_projects_projects', 'p', 'd.materi_id = p.id')
        //         ->andWhere('ms.member_id = :member')
        //         ->setParameter(':member', $member)
        //         ->orderBy('p.sort')->addOrderBy('d.name')
        //         ->execute();
    
        //     return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        // }
    }