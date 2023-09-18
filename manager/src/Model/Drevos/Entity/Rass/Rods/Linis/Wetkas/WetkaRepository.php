<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class WetkaRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Wetka::class);
        $this->em = $em;
    }

//    public function getByWetka(string $name_star, string $idVetka ): Wetka
//    {
//        /** @var Wetka $wetka */
//        if (!$wetka = $this->repo->findOneBy([
//                'nameStar' => $name_star,
//                'idVetka' => $idVetka
//
//        ]))
//        {
//            throw new EntityNotFoundException('Wetka не найдена.');
//        }
//        return $wetka;
//    }

    public function has(Id $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): Wetka
    {
        /** @var Wetka $wetka */
        if (!$wetka = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Wetka is not found.');
        }
        return $wetka;
    }

    public function add(Wetka $wetka): void
    {
        $this->em->persist($wetka);
    }
}
