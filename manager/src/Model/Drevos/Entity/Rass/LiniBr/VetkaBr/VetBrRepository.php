<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class VetBrRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(VetkaBr::class);
        $this->em = $em;
    }

//    public function getByVetkaBr(string $name_star, string $idVetka ): VetkaBr
//    {
//        /** @var VetkaBr $vetka */
//        if (!$vetka = $this->repo->findOneBy([
//                'nameStar' => $name_star,
//                'idVetka' => $idVetka
//
//        ]))
//        {
//            throw new EntityNotFoundException('VetkaBr не найдена.');
//        }
//        return $vetka;
//    }

    public function has(Id $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): VetkaBr
    {
        /** @var VetkaBr $vetka */
        if (!$vetka = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('VetkaBr is not found.');
        }
        return $vetka;
    }

    public function add(VetkaBr $vetka): void
    {
        $this->em->persist($vetka);
    }
}
