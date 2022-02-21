<?php

declare(strict_types=1);

namespace App\Model\Matkis\UseCase\U4astniks\Group\Edit;

use App\Model\Flusher;
use App\Model\Matkis\Entity\U4astniks\Group\Id;
use App\Model\Matkis\Entity\U4astniks\Group\GroupRepository;

class Handler
{
    private $groups;
    private $flusher;

    public function __construct(GroupRepository $groups, Flusher $flusher)
    {
        $this->groups = $groups;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $group = $this->groups->get(new Id($command->id));

        $group->edit($command->name);

        $this->flusher->flush();
    }
}
