<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\ChildMatka\Take;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Id;
use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatkaRepository;

class Handler
{
    private $childmatkas;
    private $flusher;
    private $uchastes;

    public function __construct(
        ChildMatkaRepository $childmatkas,
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


        $this->flusher->flush();
    }
}


