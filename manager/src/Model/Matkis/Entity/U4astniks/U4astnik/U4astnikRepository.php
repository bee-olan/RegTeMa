<?php

declare(strict_types=1);

namespace App\Model\Matkis\Entity\U4astniks\U4astnik;

use App\Model\EntityNotFoundException;
use App\Model\Matkis\Entity\U4astniks\Group\Id as GroupId;
use Doctrine\ORM\EntityManagerInterface;

class U4astnikRepository
{
	/**
	 * @var \Doctrine\ORM\EntityRepository
	 */
	private $repo;
	private $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->repo = $em->getRepository(U4astnik::class);
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

	public function get(Id $id): U4astnik
	{
		/** @var U4astnik $u4astnik */
		if (!$u4astnik = $this->repo->find($id->getValue())) {
			throw new EntityNotFoundException('U4astnik is not found.');
		}
		return $u4astnik;
	}

	public function add(U4astnik $u4astnik): void
	{
		$this->em->persist($u4astnik);
	}
}

