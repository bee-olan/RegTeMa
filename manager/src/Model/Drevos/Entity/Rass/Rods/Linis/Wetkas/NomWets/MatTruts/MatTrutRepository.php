<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class MatTrutRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(MatTrut::class);
        $this->em = $em;
    }

    public function getLiniId(string $name): Id
    {
        /** @var Lini $linia */
        if ($linia = $this->repo->findOneBy(['name' => $name]))
            return $linia->getId();
    }
    public function hasLini(string $name): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.name)')
                ->andWhere('t.name = :name')
                ->setParameter(':name', $name)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function has(Id $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): MatTrut
    {
        /** @var MatTrut $mattrut */
        if (!$mattrut = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('MatTrut is not found.');
        }
        return $mattrut;
    }

    public function add(MatTrut $mattrut): void
    {
        $this->em->persist($mattrut);
    }
}
