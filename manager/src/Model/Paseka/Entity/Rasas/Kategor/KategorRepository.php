<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Rasas\Kategor;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class KategorRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Kategor::class);
        $this->em = $em;
    }

    public function hasByName(string $name): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.name)')
                ->andWhere('t.name = :name')
                ->setParameter(':name', $name)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): Kategor
    {
        /** @var Kategor $kategor */
        if (!$kategor = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Kategor is not found.');
        }
        return $kategor;
    }

    public function add(Kategor $kategor): void
    {
        $this->em->persist($kategor);
    }

    public function remove(Kategor $kategor): void
    {
        $this->em->remove($kategor);
    }
}