<?php

declare(strict_types=1);

namespace App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\NomWets;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class NomWetFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }



    public function getMaxSortNomWet(string $wetka): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(w.sort_nom_wet) AS m')
            ->from('dre_ras_rod_lini_wet_nomws', 'w')
			->andWhere('wetka_id = :wetkas')
            ->setParameter(':wetkas', $wetka)
            ->execute()->fetch()['m'];
    }


    public function allOfWetka(string $wetka): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'w.id',
                'w.wetka_id',
                'w.nom_w',
                'w.god_w',
                'w.tit_w',
                'w.sort_nom_wet',
                '(SELECT COUNT(*) FROM dre_ras_rod_lini_wet_nomw_noms n WHERE n.nomwet_id = w.id) AS nomers'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :materi
                // ) AS members_count'
            )
            ->from('dre_ras_rod_lini_wet_nomws', 'w')
            ->andWhere('wetka_id = :wetkas ')
            ->setParameter(':wetkas', $wetka)
            ->orderBy('sort_nom_wet')
            ->orderBy('w.nom_w')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
		


    }