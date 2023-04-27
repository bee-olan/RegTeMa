<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\OtecForRas\Linias\Nomers;

use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Nomer as OtNomer;
use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class NomerRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(OtNomer::class);
        $this->em = $em;
    }

    public function has(Id $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }


    public function get(Id $id): OtNomer
    {
        /** @var OtNomer $nomer */
        if (!$nomer = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('nomer is not found.');
        }
        return $nomer;
    }
//    public function get(Id $id): OtNomer
//    {
////        dd($id);
//        /** @var OtNomer $nomer */
//        if (!$nomer = $this->repo->find($id->getValue())) {
////         dd($id->getValue());
//            throw new EntityNotFoundException('Nomer is not found.?????????');
//        }
//        return $nomer;
//    }

    public function add(OtNomer $nomer): void
    {
        $this->em->persist($nomer);
    }
}
