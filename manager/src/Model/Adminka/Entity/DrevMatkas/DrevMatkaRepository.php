<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\DrevMatkas;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class DrevMatkaRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(DrevMatka::class);
        $this->em = $em;
    }

    public function get(Id $id): DrevMatka
    {
        /** @var DrevMatka $drevmatka */
        if (!$drevmatka = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('DrevMatka is not found.');
        }
        return $drevmatka;
    }

    public function getDrevMatId(string $name): Id
    {
        /** @var DrevMatka $drevmatka */
        if (!$drevmatka = $this->repo->findOneBy(['name' => $name])) {
            throw new EntityNotFoundException('Нет такой ПлемМатки.');
        }
        return $drevmatka->getId();
    }

//    public function getPlemSezon(Id $id, string $sezon): DrevMatka
//    {
//        /** @var DrevMatka $drevmatka */
//        if (!$drevmatka = $this->repo->find($id->getValue())) {
//            throw new EntityNotFoundException('DrevMatka is not found.');
//        }
//        return $drevmatka;
//    }

    public function hasByName(string $name): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.name)')
                ->andWhere('t.name = :name')
                ->setParameter(':name', $name)
                ->getQuery()->getSingleScalarResult() > 0;
    }


    public function hasBySort(int $sort): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.sort = :sort')
                ->setParameter(':sort', $sort)
                ->getQuery()->getSingleScalarResult() > 0;
    }


    public function add(DrevMatka $drevmatka): void
    {
        $this->em->persist($drevmatka);
    }

    public function remove(DrevMatka $drevmatka): void
    {
        $this->em->remove($drevmatka);
    }
}
