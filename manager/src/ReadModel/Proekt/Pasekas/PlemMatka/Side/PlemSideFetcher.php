<?php

declare(strict_types=1);

namespace App\ReadModel\Proekt\Pasekas\PlemMatka\Side;

use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;

use Doctrine\DBAL\FetchMode;
use App\ReadModel\Proekt\Pasekas\PlemMatka\Side\Filter\Filter;
use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class PlemSideFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, 
                                PaginatorInterface $paginator, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
        $this->repository = $em->getRepository(PlemMatka::class);
    }

    public function find(string $id): ?PlemMatka
    {
        return $this->repository->find($id);
    }

    public function findIdByPlemMatka(string $name): ?IdView
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'

            )
            ->from('admin_matkas_plemmatkas')
            ->where('name = :name')
            ->setParameter(':name', $name)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, IdView::class);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    public function getMaxSort(): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(p.sort) AS m')
            ->from('admin_matkas_plemmatkas', 'p')

            ->execute()->fetch()['m'];
    }


    public function getMaxSortPerson(int $persona): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(p.sort) AS m')
            ->from('admin_matkas_plemmatkas', 'p')
            ->andWhere('persona = :personas')
            ->setParameter(':personas', $persona)
            ->execute()->fetch()['m'];
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

    public function existsPerson(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('adminka_uchasties_personas')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }

    public function existsMesto(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('mesto_mestonomers')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }

    public function exists(int $sort): bool
    {
       // dd($sort);
        return $this->connection->createQueryBuilder()
                ->select('COUNT (sort)')
                ->from('admin_matkas_plemmatkas')
                ->where('sort = :sort')
                ->setParameter(':sort', $sort)
                ->execute()->fetchColumn() > 0;
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
                'p.title',
                'p.persona_id',
                'p.status',
                'p.sort',
//                'p.rasa_id',
                'p.kategoria_id',
                'p.nomer_id',
                'p.goda_vixod ',
                'pe.nomer as persona',
                'k.name AS kategoria'
//                ,
//                'd.name as departs'

            )
            ->from('admin_matkas_plemmatkas', 'p')
            ->innerJoin('p', 'adminka_uchasties_personas', 'pe', 'p.persona_id = pe.id')
            ->innerJoin('p', 'admin_matkas_kategorias', 'k', 'p.kategoria_id = k.id')
        ;

        if ($filter->uchastie) {
            $qb->andWhere('EXISTS (
                SELECT ms.uchastie_id FROM adminka_matkas_plemmatka_uchastniks ms WHERE ms.plemmatka_id = p.id AND ms.uchastie_id = :uchastie
            )');
            $qb->setParameter(':uchastie', $filter->uchastie);
        }


        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('LOWER(p.name)', ':name'));
            $qb->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }

        if ($filter->status) {
            $qb->andWhere('p.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

//        if ($filter->kategoria) {
//            $qb->andWhere($qb->expr()->like('LOWER(p.name_kateg)', ':name_kateg'));
//            $qb->setParameter(':name_kateg', '%' . mb_strtolower($filter->name_kateg) . '%');
//        }
//
//        if ($filter->persona) {
//            $qb->andWhere('p.persona = :persona');
//            $qb->setParameter(':persona', $filter->persona);
//        }
//,'name_kateg'
        if (!\in_array($sort, ['name', 'status','persona'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }
}
