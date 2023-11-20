<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\DrevMatkas\ChildDrevs;

//use App\Model\Adminka\Entity\Matkas\ChildDrev\ChildMatka;
//use App\ReadModel\Adminka\Matkas\ChildMatka\Filter\Filter;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class ChildDrevFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
        $this->repository = $em->getRepository(ChildDrev::class);
    }

    public function find(string $id): ?ChildDrev
    {
        return $this->repository->find($id);
    }

    public function AllExecutorChild(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'childmatka_id',
                'uchastie_id'
            )
            ->from('admin_matkas_childmatkas_executors')
            ->orderBy('childmatka_id')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function listZakazForTochka(string $uchastie): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'e.childmatka_id AS id',
                'e.uchastie_id',
                'm.name AS name',
                'm.start_date AS god_test'
            )
            ->from('admin_matkas_childmatkas_executors', 'e')
            ->innerJoin('e', 'admin_matkas_childmatkas', 'm', 'e.childmatka_id = m.id')
//            ->innerJoin('e', 'admin_sezons_godas', 'g', 'e.childmatka_id = m.id')
            ->andWhere('e.uchastie_id = :uchasties')
            ->setParameter(':uchasties', $uchastie)
            // ->orderBy('d.name')->addOrderBy('name')
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
    public function all(Filter $filter, int $page, int $size, ?string $sort, ?string $direction): PaginationInterface
    {
        if (!\in_array($sort, [null, 't.id', 't.date',  'author_name', 'plemmatka_name', 'name', 't.type', 't.plan_date', 't.priority','t.urowni', 't.status'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb = $this->connection->createQueryBuilder()
            ->select(
                't.id',
                't.plemmatka_id',
                't.author_id',
                't.date',
                'm.nike AS  author_name',
                'p.name AS plemmatka_name',
                'p.sort AS plemmatka_sort',
                'p.goda_vixod AS plemmatka_god',
                't.name',
                't.content',
                't.parent_id AS parent',
                't.type',
                't.priority',
                't.plan_date',
                't.status',
                't.sezon_plem ',
                't.urowni',
                'r.nomer AS mesto',
                'u.nomer AS  author_persona'
            )
            ->from('admin_matkas_childmatkas', 't')
            ->innerJoin('t', 'admin_uchasties_uchasties', 'm', 't.author_id = m.id')
            ->innerJoin('t', 'admin_matkas_plemmatkas', 'p', 't.plemmatka_id = p.id')
            ->innerJoin('t', 'mesto_mestonomers', 'r', 't.author_id = r.id')
            ->innerJoin('t', 'adminka_uchasties_personas', 'u', 't.author_id = u.id')
        ;

        if ($filter->uchastie) {
            $qb->innerJoin('t', 'adminka_matkas_plemmatka_uchastniks', 'ms', 't.plemmatka_id = ms.plemmatka_id');
            $qb->andWhere('ms.uchastie_id = :uchastie');
            $qb->setParameter(':uchastie', $filter->uchastie);
        }

        if ($filter->plemmatka) {
            $qb->andWhere('t.plemmatka_id = :plemmatka');
            $qb->setParameter(':plemmatka', $filter->plemmatka);
        }

        if ($filter->author) {
            $qb->andWhere('t.author_id = :author');
            $qb->setParameter(':author', $filter->author);
        }


        if ($filter->text) {
            $vector = "(setweight(to_tsvector(t.name),'A') || setweight(to_tsvector(coalesce(t.content,'')), 'B'))";
            $query = 'plainto_tsquery(:text)';
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('LOWER(CONCAT(t.name, \' \', coalesce(t.content, \'\')))', ':text'),
                "$vector @@ $query"
            ));
            $qb->setParameter(':text', '%' . mb_strtolower($filter->text) . '%');
            if (empty($sort)) {
                $sort = "ts_rank($vector, $query)";
                $direction = 'desc';
            }
        }

        if ($filter->type) {
            $qb->andWhere('t.type = :type');
            $qb->setParameter(':type', $filter->type);
        }

        if ($filter->priority) {
            $qb->andWhere('t.priority = :priority');
            $qb->setParameter(':priority', $filter->priority);
        }

        if ($filter->status) {
            $qb->andWhere('t.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

         if ($filter->executor) {
             $qb->innerJoin('t', 'admin_matkas_childmatkas_executors', 'e', 'e.childmatka_id = t.id');
             $qb->andWhere('e.uchastie_id = :executor');
             $qb->setParameter(':executor', $filter->executor);
         }

        if ($filter->roots) {
            $qb->andWhere('t.parent_id IS NULL');
        }

        if ($filter->urowni) {
            $qb->andWhere('t.urowni >= :urowni');
          $qb->setParameter(':urowni', $filter->urowni);
        }

        if (!$sort) {
            $sort = 't.id';
            $direction = $direction ?: 'desc';
        } else {
            $direction = $direction ?: 'asc';
        }

        $qb->orderBy($sort, $direction);


        $pagination = $this->paginator->paginate($qb, $page, $size);

        $childmatkas = (array)$pagination->getItems();
        $executors = $this->batchLoadExecutors(array_column($childmatkas, 'id'));

        $pagination->setItems(array_map(static function (array $childmatka) use ($executors) {
            return array_merge($childmatka, [
                'executors' => array_filter($executors, static function (array $executor) use ($childmatka) {
                    return $executor['childmatka_id'] === $childmatka['id'];
                }),
            ]);
        }, $childmatkas));

        return $pagination;
    }

     public function childrenOf(int $childmatka): array
     {
         $stmt = $this
             ->connection->createQueryBuilder()
             ->select(
                 't.id',
                 't.date',
                 't.plemmatka_id',
                 'p.name plemmatka_name',
                 't.name',
                 't.content',
                 't.parent_id AS parent',
                 't.type',
                 't.priority',
                 't.plan_date',
                 't.status'
             )
             ->from('admin_matkas_childmatkas', 't')
             ->innerJoin('t', 'admin_matkas_plemmatkas', 'p', 't.plemmatka_id = p.id')
             ->andWhere('t.parent_id = :parent')
             ->setParameter(':parent', $childmatka)
             ->orderBy('date', 'desc')
             ->execute();

         $childmatkas = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//         dd($childmatkas);
         $executors = $this->batchLoadExecutors(array_column($childmatkas, 'id'));

         return array_map(static function (array $childmatka) use ($executors) {
             return array_merge($childmatka, [
                 'executors' => array_filter($executors, static function (array $executor) use ($childmatka) {
                     return $executor['childmatka_id'] === $childmatka['id'];
                 }),
             ]);
         }, $childmatkas);
     }

     private function batchLoadExecutors(array $ids): array
     {
         $stmt = $this->connection->createQueryBuilder()
             ->select(
                 'e.childmatka_id',
//                 'TRIM(CONCAT(m.name_first, \' \', m.name_last)) AS name'
                 'm.nike AS name'
             )
             ->from('admin_matkas_childmatkas_executors', 'e')
             ->innerJoin('e', 'admin_uchasties_uchasties', 'm', 'm.id = e.uchastie_id')
             ->andWhere('e.childmatka_id IN (:childmatka)')
             ->setParameter(':childmatka', $ids, Connection::PARAM_INT_ARRAY)
             ->orderBy('name')
             ->execute();

         return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
     }

}
