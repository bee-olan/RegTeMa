<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\MatTests\PlemTest;


use App\Model\Adminka\Entity\MatTests\PlemTest\PlemTest;
use App\ReadModel\Adminka\MatTests\PlemTest\Filter\Filter;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class PlemTestFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, 
                                PaginatorInterface $paginator, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
        $this->repository = $em->getRepository(PlemTest::class);
    }

    public function find(string $id): ?PlemTest
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



    public function exists(int $id): bool
    {
//        dd($id);
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('admin_mattest_plemtests')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }


    public function infaRasaNom(string $rasaNomId): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'n.name_star AS nomer',
                'n.name AS nomer_n',
                'l.name_star AS linia',
                'l.name AS linia_n',
                'r.title AS rasa',
                'r.name AS name'
            )
            ->from('admin_rasa_linia_nomers', 'n')
            ->innerJoin('n', 'admin_rasa_linias', 'l', 'n.linia_id = l.id')
            ->innerJoin('l', 'admin_rasas', 'r', 'l.rasa_id = r.id')
            ->andWhere('n.id = :rasaNomId')
            ->setParameter(':rasaNomId', $rasaNomId)
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }


    public function infaMesto(string $mesto): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'r.name AS raion',
                'ob.name AS oblast',
                'ok.name AS okrug'
            )
            ->from('mesto_okrug_oblast_raions', 'r')
            ->innerJoin('r', 'mesto_okrug_oblasts', 'ob', 'r.oblast_id = ob.id')
            ->innerJoin('ob', 'mesto_okrugs', 'ok', 'ob.okrug_id = ok.id')

            ->andWhere('r.mesto = :mesto')
            ->setParameter(':mesto', $mesto)
           // ->orderBy('p.sort')->addOrderBy('d.name')
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
    public function all(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'p.id',
                'p.name',
                'p.star_linia',
                'p.star_nomer',
                'p.title',
                'p.status',
//                'p.sort',
                'p.goda_vixod '


//                '(SELECT COUNT(*) FROM admin_matkas_plemmatka_departments d WHERE d.plemmatka_id = p.id) AS departments_count',
//                '(SELECT COUNT(*) FROM admin_matkas_childmatkas c WHERE c.plemmatka_id = p.id) AS child_count'
            )
            ->from('admin_mattest_plemtests', 'p')
//            ->innerJoin('p', 'adminka_uchasties_personas', 'pe', 'p.persona_id = pe.id')
//            ->innerJoin('p', 'admin_matkas_kategorias', 's', 'p.kategoria_id = s.id')
        ;
        if ($filter->uchastie) {
            $qb->andWhere('EXISTS (
                SELECT ms.uchastie_id FROM adminka_matkas_plemmatka_uchastniks ms WHERE ms.plemmatka_id = p.id AND ms.uchastie_id = :uchastie
            )');
            $qb->setParameter(':uchastie', $filter->uchastie);
        }


        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('p.name', ':name'));
            $qb->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }

        if ($filter->status) {
            $qb->andWhere('p.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

        if (!\in_array($sort, ['name', 'status','persona'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }
}
