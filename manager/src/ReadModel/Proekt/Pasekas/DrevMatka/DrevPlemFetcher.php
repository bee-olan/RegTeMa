<?php

declare(strict_types=1);

namespace App\ReadModel\Proekt\Pasekas\DrevMatka;


use App\Model\Adminka\Entity\DrevMatkas\DrevMatka;
use App\ReadModel\Proekt\Pasekas\DrevMatka\Filter\Filter;
use Doctrine\DBAL\FetchMode;

use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class DrevPlemFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, 
                                PaginatorInterface $paginator, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
        $this->repository = $em->getRepository(DrevMatka::class);
    }

    public function find(string $id): ?DrevMatka
    {
        return $this->repository->find($id);
    }


    public function allList(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'
            )
            ->from('admin_matkas_plemmatkas')
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
                'd.id',
                'd.nomer_id',
                'd.mesto_id',
                'd.persona_id',
                'd.name',
                'd.sort',
                'd.status',
//                'pe.nomer as persona',

                '(SELECT COUNT(*) FROM adm_drev_sezondrevs s WHERE s.plemmatka_id = d.id) AS sezondrevs_count'
//                '(SELECT COUNT(*) FROM admin_matkas_childmatkas c WHERE c.plemmatka_id = d.id) AS child_count'
            )
            ->from('admin_drevmatkas', 'd')
//            ->innerJoin('p', 'adminka_uchasties_personas', 'pe', 'd.persona_id = pe.id')
        ;

//        if ($filter->uchastie) {
//            $qb->andWhere('EXISTS (
//                SELECT ms.uchastie_id FROM adminka_matkas_plemmatka_uchastniks ms WHERE ms.plemmatka_id = d.id AND ms.uchastie_id = :uchastie
//            )');
//            $qb->setParameter(':uchastie', $filter->uchastie);
//        }


        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('LOWER(d.name)', ':name'));
            $qb->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }

//        if ($filter->status) {
//            $qb->andWhere('d.status = :status');
//            $qb->setParameter(':status', $filter->status);
//        }

//
//        if ($filter->persona) {
//            $qb->andWhere('d.persona = :persona');
//            $qb->setParameter(':persona', $filter->persona);
//        }
//, 'kategoria', 'goda_vixod','persona'
        if (!\in_array($sort, ['name'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }
}
