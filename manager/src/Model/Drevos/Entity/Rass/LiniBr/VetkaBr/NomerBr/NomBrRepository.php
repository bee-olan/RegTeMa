<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class NomBrRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(NomerBr::class);
        $this->em = $em;
    }

//    public function getByNomerBr(string $name_star, string $idVetka ): NomerBr
//    {
//        /** @var NomerBr $vetka */
//        if (!$vetka = $this->repo->findOneBy([
//                'nameStar' => $name_star,
//                'idVetka' => $idVetka
//
//        ]))
//        {
//            throw new EntityNotFoundException('NomerBr не найдена.');
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

    public function get(Id $id): NomerBr
    {
        /** @var NomerBr $nomer */
        if (!$nomer = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('NomerBr is not found.');
        }
        return $nomer;
    }

    public function add(NomerBr $nomer): void
    {
        $this->em->persist($nomer);
    }
}
