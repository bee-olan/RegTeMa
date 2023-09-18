<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Noms;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class NomRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Nom::class);
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

    public function get(Id $id): Nom
    {
        /** @var Nom $nom */
        if (!$nom = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Nom is not found.');
        }
        return $nom;
    }

    public function add(Nom $nom): void
    {
        dd($nom);
        $this->em->persist($nom);
    }
}
