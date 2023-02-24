<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Uchasties\Group\Remove;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Uchasties\Group\GroupRepository;
use App\Model\Adminka\Entity\Uchasties\Group\Id;


class Handler
{
    private $groups;
    private $flusher;

    public function __construct(GroupRepository $groups,                               
                                Flusher $flusher)
    {
        $this->groups = $groups;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $group = $this->groups->get(new Id($command->id));

//         if ($this->Uchasties->hasByGroup($group->getId())) {
//             throw new \DomainException('Группа не пуста.');
//         }


        $this->groups->remove($group);

        $this->flusher->flush();
    }
}
