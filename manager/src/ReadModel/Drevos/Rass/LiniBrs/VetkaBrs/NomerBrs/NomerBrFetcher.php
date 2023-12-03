<?php

declare(strict_types=1);

namespace App\ReadModel\Drevos\Rass\LiniBrs\VetkaBrs\NomerBrs;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class NomerBrFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


    public function getMaxSortNom(string $vetka): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(n.sort_nom) AS m')
            ->from('dre_ras_linibr_vet_noms', 'n')
            ->andWhere('vetka_id = :vetka')
            ->setParameter(':vetka', $vetka)
            ->execute()->fetch()['m'];
    }

//    public function listOfVetkaBr(string $vetka): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'id',
//                'nom_br',
//                'god',
//                'title',
//                'status',
//                'sort_nom'
//
//            )
//            ->from('dre_ras_linibr_vet_noms')
//            ->andWhere('vetka_id = :vetka')
//            ->setParameter(':vetka', $vetka)
//            ->orderBy('sort_nom')
//            ->orderBy('god')
//            ->execute();
//
//        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
//    }

    public function allOfVetkaBr(string $vetka): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'nom_br',
                'god',
                'title',
                'status',
                'sort_nom'
//                '(SELECT COUNT(*) FROM adminka_rasa_vetkas l WHERE  l.name_star = d.name_star) AS kolvenka'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('dre_ras_linibr_vet_noms', 'd')
            ->andWhere('vetka_id = :vetka')
            ->setParameter(':vetka', $vetka)
            ->orderBy('sort_nomer')
            ->orderBy('god')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
    

    }