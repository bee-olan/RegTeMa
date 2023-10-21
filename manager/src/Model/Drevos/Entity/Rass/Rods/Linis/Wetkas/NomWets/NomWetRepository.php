<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class NomWetRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(NomWet::class);
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

    public function get(Id $id): NomWet
    {
        /** @var NomWet $nomwet */
        if (!$nomwet = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('NomWet is not found.');
        }
        return $nomwet;
    }

    public function add(NomWet $nomwet): void
    {
        $this->em->persist($nomwet);
    }
}
