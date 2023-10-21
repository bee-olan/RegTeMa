<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\Rods;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class RodRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Rod::class);
        $this->em = $em;
    }

    public function getRodId(string $nameMatkov): Id
    {
        /** @var Rod $rod */
        if ($rod = $this->repo->findOneBy(['nameMatkov' => $nameMatkov]))
        return $rod->getId();
    }
    public function hasRod(string $nameMatkov): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.nameMatkov)')
                ->andWhere('t.nameMatkov = :nameMatkov')
                ->setParameter(':nameMatkov', $nameMatkov)
                ->getQuery()->getSingleScalarResult() > 0;
    }

//    public function getByLinia(string $name_star, string $idVetka ): Linia
//    {
//        /** @var Linia $rodo */
//        if (!$rodo = $this->repo->findOneBy([
//                'nameStar' => $name_star,
//                'idVetka' => $idVetka
//
//        ]))
//        {
//            throw new EntityNotFoundException('Linia не найдена.');
//        }
//        return $rodo;
//    }

    public function has(Id $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): Rod
    {
        /** @var Rod $rodo */
        if (!$rodo = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Rod is not found.');
        }
        return $rodo;
    }

    public function add(Rod $rodo): void
    {
        $this->em->persist($rodo);
    }
}
