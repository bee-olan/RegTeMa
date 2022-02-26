<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Pchelowods\Pchelowod\Move;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Pchelowods\Group\GroupRepository;
use App\Model\Paseka\Entity\Pchelowods\Group\Id as GroupId;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Id;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\PchelowodRepository;

class Handler
{
    private $pchelowods;
    private $groups;
    private $flusher;

    public function __construct(PchelowodRepository $pchelowods, GroupRepository $groups, Flusher $flusher)
    {
        $this->pchelowods = $pchelowods;
        $this->groups = $groups;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $pchelowod = $this->pchelowods->get(new Id($command->id));
        $group = $this->groups->get(new GroupId($command->group));

        $pchelowod->move($group);

        $this->flusher->flush();
    }
}