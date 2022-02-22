<?php

declare(strict_types=1);

namespace App\Model\Matkis\UseCase\U4astniks\U4astnik\Move;

use App\Model\Flusher;
use App\Model\Matkis\Entity\U4astniks\Group\GroupRepository;
use App\Model\Matkis\Entity\U4astniks\Group\Id as GroupId;
use App\Model\Matkis\Entity\U4astniks\U4astnik\Id;
use App\Model\Matkis\Entity\U4astniks\U4astnik\U4astnikRepository;

class Handler
{
    private $u4astniks;
    private $groups;
    private $flusher;

    public function __construct(U4astnikRepository $u4astniks, GroupRepository $groups, Flusher $flusher)
    {
        $this->u4astniks = $u4astniks;
        $this->groups = $groups;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $u4astnik = $this->u4astniks->get(new Id($command->id));
        $group = $this->groups->get(new GroupId($command->group));

        $u4astnik->move($group);

        $this->flusher->flush();
    }
}