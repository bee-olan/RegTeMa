<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Rasas\Rasa;

use App\ReadModel\Paseka\Rasas\Rasa\Filter\Filter;
use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class RasaFetcher
{
    private $connection;
    private $paginator;

    public function __construct(Connection $connection, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
    }

    public function getMaxSort(): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(p.sort) AS m')
            ->from('paseka_rasas_rasas', 'p')
            ->execute()->fetch()['m'];
    }

    public function allList(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name',
                'psewdo'
            )
            ->from('paseka_rasas_rasas')
            ->orderBy('sort')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    /**
     * @param Filter $filter
     * @param int $page
     * @param int $size
     * @param string $sort
     * @param string $direction
     * @return PaginationInterface
     */
    public function all(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'p.id',
                'p.name',
                'p.psewdo',
                'p.sort'
            )
            ->from('paseka_rasas_rasas', 'p');

        // if ($filter->member) {
        //     $qb->andWhere('EXISTS (
        //         SELECT ms.member_id FROM work_projects_project_memberships ms WHERE ms.project_id = p.id AND ms.member_id = :member
        //     )');
        //     $qb->setParameter(':member', $filter->member);
        // }

        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('LOWER(p.name)', ':name'));
            $qb->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }

        // if ($filter->status) {
        //     $qb->andWhere('p.status = :status');
        //     $qb->setParameter(':status', $filter->status);
        // }

        if (!\in_array($sort, ['sort', 'name', 'psewdo'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }
}
