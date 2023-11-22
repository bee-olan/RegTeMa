<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\DrevMatkas\ChildDrevs;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class ChildDrevRepository
{
    private $repo;
    private $connection;
    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(ChildDrev::class);
        $this->connection = $em->getConnection();
        $this->em = $em;
    }

    /**
     * @param Id $id
     * @return ChildDrev[]
     */
    public function allByParent(Id $id): array
    {
        return $this->repo->findBy(['parent' => $id->getValue()]);
    }

    public function get(Id $id): ChildDrev
    {
        /** @var ChildDrev $childmatka */
        if (!$childmatka = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Дочерняя матка не найдена.');
        }
        return $childmatka;
    }

    public function add(ChildDrev $childmatka): void
    {
        $this->em->persist($childmatka);
    }

    public function remove(ChildDrev $childmatka): void
    {
        $this->em->remove($childmatka);
    }

    public function nextId(): Id
    {
        return new Id((int)$this->connection->query('SELECT nextval(\'admin_matkas_childmatkas_seq\')')->fetchColumn());
    }
}
