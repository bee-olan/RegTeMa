<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\Rods\Linis;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class LiniRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Lini::class);
        $this->em = $em;
    }

//    public function getByLini(string $name_star, string $idVetka ): Lini
//    {
//        /** @var Lini $linia */
//        if (!$linia = $this->repo->findOneBy([
//                'nameStar' => $name_star,
//                'idVetka' => $idVetka
//
//        ]))
//        {
//            throw new EntityNotFoundException('Lini не найдена.');
//        }
//        return $linia;
//    }

    public function has(Id $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): Lini
    {
        /** @var Lini $linia */
        if (!$linia = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Lini is not found.');
        }
        return $linia;
    }

    public function add(Lini $linia): void
    {
        $this->em->persist($linia);
    }
}
