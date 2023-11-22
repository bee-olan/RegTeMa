<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\TakeAndStart;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;

use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrevRepository;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\Id;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrev;

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
        $childmatka = $this->childmatkas->get(new Id($command->id));
        $actor = $this->uchastes->get(new UchastieId($command->actor));

        if (!$childmatka->hasExecutor($actor->getId())) {
            $childmatka->assignExecutor($actor, new \DateTimeImmutable(), $actor);
        }

        $childmatka->start($actor, new \DateTimeImmutable());

        $this->flusher->flush();
    }
}

