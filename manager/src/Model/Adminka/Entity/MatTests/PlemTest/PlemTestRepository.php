<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\MatTests\PlemTest;

//use App\Model\Adminka\Entity\Matkas\Role\Id as RoleId;
use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class PlemTestRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(PlemTest::class);
        $this->em = $em;
    }

//    public function hasUchastiesWithRole(RoleId $id): bool
//    {
//        return $this->repo->createQueryBuilder('p')
//                ->select('COUNT(p.id)')
//                ->innerJoin('p.uchastniks', 'ms')
//                ->innerJoin('ms.roles', 'r')
//                ->andWhere('r.id = :role')
//                ->setParameter(':role', $id->getValue())
//                ->getQuery()->getSingleScalarResult() > 0;
//    }


    public function get(Id $id): PlemTest
    {
        /** @var PlemTest $plemtest */
        if (!$plemtest = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('PlemTest is not found.');
        }
        return $plemtest;
    }

    public function getPlemSezon(Id $id, string $sezon): PlemTest
    {
        /** @var PlemTest $plemtest */
        if (!$plemtest = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('PlemTest is not found.');
        }
        return $plemtest;
    }

    public function hasBySort(int $sort): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.sort = :sort')
                ->setParameter(':sort', $sort)
                ->getQuery()->getSingleScalarResult() > 0;
    }

//    public function hasSortPerson(int $sort, int $persona): bool
//    {
//        return $this->repo->createQueryBuilder('t')
//                ->select('COUNT(t.id)')
//                ->andWhere('t.sort = :sort')
//                ->setParameter(':sort', $sort)
//                ->andWhere('t.persona = :persona')
//                ->setParameter(':persona', $persona)
//                ->getQuery()->getSingleScalarResult() > 0;
//    }

    public function add(PlemTest $plemtest): void
    {
        $this->em->persist($plemtest);
    }

    public function remove(PlemTest $plemtest): void
    {
        $this->em->remove($plemtest);
    }
}
