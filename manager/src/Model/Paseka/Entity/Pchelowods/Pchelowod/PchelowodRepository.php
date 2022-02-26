<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Pchelowods\Pchelowod;

use App\Model\EntityNotFoundException;
use App\Model\Paseka\Entity\Pchelowods\Group\Id as GroupId;
use Doctrine\ORM\EntityManagerInterface;

class PchelowodRepository
{
	/**
	 * @var \Doctrine\ORM\EntityRepository
	 */
	private $repo;
	private $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->repo = $em->getRepository(Pchelowod::class);
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

	public function hasByGroup(GroupId $id): bool
	{
		return $this->repo->createQueryBuilder('t')
				->select('COUNT(t.id)')
				->andWhere('t.group = :group')
				->setParameter(':group', $id->getValue())
				->getQuery()->getSingleScalarResult() > 0;
	}

	public function get(Id $id): Pchelowod
	{
		/** @var Pchelowod $pchelowod */
		if (!$pchelowod = $this->repo->find($id->getValue())) {
			throw new EntityNotFoundException('Pchelowod is not found.');
		}
		return $pchelowod;
	}

	public function add(Pchelowod $pchelowod): void
	{
		$this->em->persist($pchelowod);
	}
}

