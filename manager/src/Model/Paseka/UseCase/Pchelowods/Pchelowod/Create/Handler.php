<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Pchelowods\Pchelowod\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Pchelowods\Group\GroupRepository;
use App\Model\Paseka\Entity\Pchelowods\Group\Id as GroupId;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Email;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Pchelowod;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Id;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\PchelowodRepository;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Name;

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
        $id = new Id($command->id);

        if ($this->pchelowods->has($id)) {
            throw new \DomainException('Pchelowod already exists.');
        }

        $group = $this->groups->get(new GroupId($command->group));

        $pchelowod = new Pchelowod(
            $id,
            $group,
            new Name(
                $command->firstName,
                $command->lastName
            ),
            new Email($command->email)
        );

        $this->pchelowods->add($pchelowod);

        $this->flusher->flush();
    }
}

