<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass\LiniBr;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class LiniBrRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(LiniBr::class);
        $this->em = $em;
    }

    public function getByLiniBr(string $name_star, string $idVetka ): LiniBr
    {
        /** @var LiniBr $linia */
        if (!$linia = $this->repo->findOneBy([
                'nameStar' => $name_star,
                'idVetka' => $idVetka

        ]))
        {
            throw new EntityNotFoundException('LiniBr не найдена.');
        }
        return $linia;
    }

    public function has(Id $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): LiniBr
    {
        /** @var LiniBr $linia */
        if (!$linia = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('LiniBr is not found.');
        }
        return $linia;
    }

    public function add(LiniBr $linia): void
    {
        $this->em->persist($linia);
    }
}
