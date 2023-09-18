<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Strans;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class StranRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Stran::class);
        $this->em = $em;
    }

    public function get(Id $id): Stran
    {
        /** @var Stran $sparing */
        if (!$sparing = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Stran is not found.');
        }
        return $sparing;
    }

    public function add(Stran $sparing): void
    {
        $this->em->persist($sparing);
    }

    public function remove(Stran $sparing): void
    {
        $this->em->remove($sparing);
    }
}
