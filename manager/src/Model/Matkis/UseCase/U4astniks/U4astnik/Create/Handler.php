<?php

declare(strict_types=1);

namespace App\Model\Matkis\UseCase\U4astniks\U4astnik\Create;

use App\Model\Flusher;
use App\Model\Matkis\Entity\U4astniks\Group\GroupRepository;
use App\Model\Matkis\Entity\U4astniks\Group\Id as GroupId;
use App\Model\Matkis\Entity\U4astniks\U4astnik\Email;
use App\Model\Matkis\Entity\U4astniks\U4astnik\U4astnik;
use App\Model\Matkis\Entity\U4astniks\U4astnik\Id;
use App\Model\Matkis\Entity\U4astniks\U4astnik\U4astnikRepository;
use App\Model\Matkis\Entity\U4astniks\U4astnik\Name;

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
        $id = new Id($command->id);

        if ($this->u4astniks->has($id)) {
            throw new \DomainException('u4astniks already exists.');
        }

        $group = $this->groups->get(new GroupId($command->group));

        $u4astnik = new U4astnik(
            $id,
            $group,
            new Name(
                $command->firstName,
                $command->lastName
            ),
            new Email($command->email)
        );

        $this->u4astniks->add($u4astnik);

        $this->flusher->flush();
    }
}

