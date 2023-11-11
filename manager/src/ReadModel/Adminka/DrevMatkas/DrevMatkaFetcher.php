<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\DrevMatkas;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka;

use App\ReadModel\Adminka\DrevMatkas\Filter\Filter;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class DrevMatkaFetcher
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

//    public function findIdByPlemMatka(string $name): ?IdView
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'id',
//                'name'
//
//            )
//            ->from('admin_matkas_plemmatkas')
//            ->where('name = :name')
//            ->setParameter(':name', $name)
//            ->execute();
//
//        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, IdView::class);
//        $result = $stmt->fetch();
//
//        return $result ?: null;
//    }

    public function getMaxSort(): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(dm.sort) AS m')
            ->from('admin_drevmatkas', 'dm')
            ->execute()->fetch()['m'];
    }


//    public function allList(): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'id',
//                'name'
//            )
//            ->from('admin_drevmatkas')
//            ->orderBy('sort')
//            ->execute();
//
//        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
//    }

//    public function existsPerson(string $id): bool
//    {
//        return $this->connection->createQueryBuilder()
//                ->select('COUNT (id)')
//                ->from('adminka_uchasties_personas')
//                ->where('id = :id')
//                ->setParameter(':id', $id)
//                ->execute()->fetchColumn() > 0;
//    }

//    public function existsMesto(string $id): bool
//    {
//        return $this->connection->createQueryBuilder()
//                ->select('COUNT (id)')
//                ->from('mesto_mestonomers')
//                ->where('id = :id')
//                ->setParameter(':id', $id)
//                ->execute()->fetchColumn() > 0;
//    }

//    public function exists(int $sort): bool
//    {
//       // dd($sort);
//        return $this->connection->createQueryBuilder()
//                ->select('COUNT (sort)')
//                ->from('admin_drevmatkas')
//                ->where('sort = :sort')
//                ->setParameter(':sort', $sort)
//                ->execute()->fetchColumn() > 0;
//    }


//    public function infaRasaNom(string $rasaNomId): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'n.name_star AS nomer',
//                'n.name AS nomer_n',
//                'l.name_star AS linia',
//                'l.name AS linia_n',
//                'r.title AS rasa',
//                'r.name AS name'
//            )
//            ->from('admin_rasa_linia_nomers', 'n')
//            ->innerJoin('n', 'admin_rasa_linias', 'l', 'n.linia_id = l.id')
//            ->innerJoin('l', 'admin_rasas', 'r', 'l.rasa_id = r.id')
//            ->andWhere('n.id = :rasaNomId')
//            ->setParameter(':rasaNomId', $rasaNomId)
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }


//    public function infaMesto(string $mesto): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'r.name AS raion',
//                'ob.name AS oblast',
//                'ok.name AS okrug'
//            )
//            ->from('mesto_okrug_oblast_raions', 'r')
//            ->innerJoin('r', 'mesto_okrug_oblasts', 'ob', 'r.oblast_id = ob.id')
//            ->innerJoin('ob', 'mesto_okrugs', 'ok', 'ob.okrug_id = ok.id')
//
//            ->andWhere('r.mesto = :mesto')
//            ->setParameter(':mesto', $mesto)
//           // ->orderBy('dm.sort')->addOrderBy('d.name')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'dm.id',
                'dm.nomer_id',
                'dm.mesto_id',
                'dm.persona_id',
                'dm.name',
                'dm.sort',
                'dm.status',
                '(SELECT COUNT(*) FROM adm_drev_sezondrevs s WHERE s.plemmatka_id = dm.id) AS sezondrevs_count'
            //                '(SELECT COUNT(*) FROM admin_matkas_childmatkas c WHERE c.plemmatka_id = p.id) AS child_count'
            )
            ->from('admin_drevmatkas', 'dm')
            ->orderBy('sort')

            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    /**
     * @param Filter $filter
     * @param int $page
     * @param int $size
     * @param string $sort
     * @param string $direction
     * @return PaginationInterface
     */
    public function allPagin(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'dm.id',
                'dm.name',
                'dm.persona_id',
                'dm.status',
                'dm.sort',
//                'pe.nomer as persona',
                '(SELECT COUNT(*) FROM adm_drev_sezondrevs s WHERE s.plemmatka_id = dm.id) AS sezondrevs_count'
           )
            ->from('admin_drevmatkas', 'dm')
//            ->innerJoin('p', 'adminka_uchasties_personas', 'pe', 'p.persona_id = pe.id')

        ;
//        if ($filter->uchastie) {
//            $qb->andWhere('EXISTS (
//                SELECT ms.uchastie_id FROM adminka_matkas_plemmatka_uchastniks ms WHERE ms.plemmatka_id = p.id AND ms.uchastie_id = :uchastie
//            )');
//            $qb->setParameter(':uchastie', $filter->uchastie);
//        }


        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('dm.name', ':name'));
            $qb->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }

        if ($filter->status) {
            $qb->andWhere('dm.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

        if (!\in_array($sort, ['name', 'status'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }
}
