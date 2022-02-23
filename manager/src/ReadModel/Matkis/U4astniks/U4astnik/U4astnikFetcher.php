<?php
// namespace App\ReadModel\Matkis\U4astniks\U4astnik;

// use App\Model\Matkis\Entity\U4astniks\U4astnik\U4astnik;
// use App\ReadModel\Matkis\U4astniks\U4astnik\Filter\Filter;

declare(strict_types=1);

namespace App\ReadModel\Matkis\U4astniks\U4astnik;

use App\Model\Matkis\Entity\U4astniks\U4astnik\U4astnik;
use App\Model\Matkis\Entity\U4astniks\U4astnik\Status;
use App\ReadModel\Matkis\U4astniks\U4astnik\Filter\Filter;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class U4astnikFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(U4astnik::class);
        $this->paginator = $paginator;
    }

    public function find(string $id): ?U4astnik
    {
        return $this->repository->find($id);
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
                'm.id',
                'TRIM(CONCAT(m.name_first, \' \', m.name_last)) AS name',
                'm.email',
                'g.name as group',
                'm.status',
                '(SELECT COUNT(*) FROM work_projects_project_memberships ms WHERE ms.member_id = m.id) as memberships_count'
            )
            ->from('matkis_u4astniks_u4astniks', 'm')
            ->innerJoin('m', 'matkis_u4astniks_groups', 'g', 'm.group_id = g.id');

        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('LOWER(CONCAT(m.name_first, \' \', m.name_last))', ':name'));
            $qb->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }

        if ($filter->email) {
            $qb->andWhere($qb->expr()->like('LOWER(m.email)', ':email'));
            $qb->setParameter(':email', '%' . mb_strtolower($filter->email) . '%');
        }

        if ($filter->status) {
            $qb->andWhere('m.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

        if ($filter->group) {
            $qb->andWhere('m.group_id = :group');
            $qb->setParameter(':group', $filter->group);
        }

        if (!\in_array($sort, ['name', 'email', 'group', 'status'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

			$qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }

    public function exists(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('matkis_u4astniks_u4astniks')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }


    public function activeGroupedList(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select([
                'm.id',
                'CONCAT(m.name_first, \' \', m.name_last) AS name',
                'g.name AS group'
            ])
            ->from('matkis_u4astniks_u4astniks', 'm')
            ->leftJoin('m', 'matkis_u4astniks_groups', 'g', 'g.id = m.group_id')
            ->andWhere('m.status = :status')
            ->setParameter(':status', Status::ACTIVE)
            ->orderBy('g.name')->addOrderBy('name')
            ->execute();
        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    // public function activeDepartmentListForProject(string $project): array
    // {
    //     $stmt = $this->connection->createQueryBuilder()
    //         ->select([
    //             'm.id',
    //             'CONCAT(m.name_first, \' \', m.name_last) AS name',
    //             'd.name AS department'
    //         ])
    //         ->from('matkis_u4astniks_u4astniks', 'm')
    //         ->innerJoin('m', 'work_projects_project_memberships', 'ms', 'ms.member_id = m.id')
    //         ->innerJoin('ms', 'work_projects_project_membership_departments', 'msd', 'msd.membership_id = ms.id')
    //         ->innerJoin('msd', 'work_projects_project_departments', 'd', 'd.id = msd.department_id')
    //         ->andWhere('m.status = :status AND ms.project_id = :project')
    //         ->setParameter(':status', Status::ACTIVE)
    //         ->setParameter(':project', $project)
    //         ->orderBy('d.name')->addOrderBy('name')
    //         ->execute();
    //     return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    // }
}
