<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Plan\Remove;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrevRepository;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\Id;


class Handler
{
    private $childmatkas;
    private $flusher;
    private $uchastes;

    public function __construct(
        ChildDrevRepository $childmatkas,
        UchastieRepository $uchastes,
        Flusher $flusher
    )
    {
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
        $this->uchastes = $uchastes;
    }

    public function handle(Command $command): void
    {
        $actor = $this->uchastes->get(new UchastieId($command->actor));
        $childmatka = $this->childmatkas->get(new Id($command->id));

        $childmatka->plan($actor, new \DateTimeImmutable(), null);

        $this->flusher->flush();
    }
}
