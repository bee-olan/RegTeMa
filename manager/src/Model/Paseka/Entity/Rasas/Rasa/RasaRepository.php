<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Rasas\Rasa;

use App\Model\EntityNotFoundException;
use App\Model\Paseka\Entity\Rasas\Kategor\Id as KategorId;
use Doctrine\ORM\EntityManagerInterface;

class RasaRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Rasa::class);
        $this->em = $em;
    }

    public function hasPchelowodsWithKategor(KategorId $id): bool
    {
        return $this->repo->createQueryBuilder('p')
                ->select('COUNT(p.id)')
                ->innerJoin('p.pcheloship', 'ms')
                ->innerJoin('ms.kategors', 'r')
                ->andWhere('r.id = :kategor')
                ->setParameter(':kategor', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): Rasa
    {
        /** @var Rasa $rasa */
        if (!$rasa = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('rasa is not found.');
        }
        return $rasa;
    }

    public function add(Rasa $rasa): void
    {
        $this->em->persist($rasa);
    }

    public function remove(Rasa $rasa): void
    {
        $this->em->remove($rasa);
    }
}
