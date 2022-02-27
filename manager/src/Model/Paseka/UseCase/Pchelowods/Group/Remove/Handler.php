<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Pchelowods\Group\Remove;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Pchelowods\Group\GroupRepository;
use App\Model\Paseka\Entity\Pchelowods\Group\Id;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\PchelowodRepository;

class Handler
{
	private $groups;
	private $pchelowods;
	private $flusher;

	public function __construct(GroupRepository $groups, PchelowodRepository $pchelowods, Flusher $flusher)
	{

		$this->groups = $groups;
		$this->pchelowods = $pchelowods;
		$this->flusher = $flusher;
	}

	public function handle(Command $command): void
	{
		$group = $this->groups->get(new Id($command->id));

		if ($this->pchelowods->hasByGroup($group->getId())) {
			throw new \DomainException('Group is not empty.');
		}

		$this->groups->remove($group);

		$this->flusher->flush();
	}
}

