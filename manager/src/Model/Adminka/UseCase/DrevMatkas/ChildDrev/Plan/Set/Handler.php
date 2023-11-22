<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Plan\Set;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;

use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrevRepository;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\Id;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrev;

class Handler
{
    private $uchastes;
    private $childmatkas;
    private $flusher;

    public function __construct(
        UchastieRepository $uchastes,
        ChildDrevRepository $childmatkas,
        Flusher $flusher
    )
    {
        $this->uchastes = $uchastes;
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $actor = $this->uchastes->get(new UchastieId($command->actor));
        $childmatka = $this->childmatkas->get(new Id($command->id));

        $childmatka->plan($actor, new \DateTimeImmutable(), $command->date);

        $this->flusher->flush();
    }
}
