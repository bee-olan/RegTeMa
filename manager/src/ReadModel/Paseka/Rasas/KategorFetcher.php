<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Rasas;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class KategorFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function allList(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'
            )
            ->from('paseka_rasas_kategors')
            ->orderBy('name')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'r.id',
                'r.name',
                'r.permissions'
                // ,
                // '(SELECT COUNT(*) FROM work_projects_project_membership_roles m WHERE m.role_id = r.id) AS memberships_count'
            )
            ->from('paseka_rasas_kategors', 'r')
            ->orderBy('name')
            ->execute();

        return array_map(static function (array $kategor) {
            return array_replace($kategor, [
                'permissions' => json_decode($kategor['permissions'], true)
            ]);
        }, $stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }
}

