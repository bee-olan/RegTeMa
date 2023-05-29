<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\ChildMatka\PerewodPlem;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Id;
use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;


class Handler
{
    private $uchasties;
    private $childmatkas;
    private $flusher;

    public function __construct(UchastieRepository $uchasties,
                                ChildMatkaRepository $childmatkas,
                                Flusher $flusher)
    {
        $this->uchasties = $uchasties;
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $childmatka = $this->childmatkas->get(new Id($command->id));
        $actor = $this->uchasties->get(new UchastieId($command->actor));

//        if (!$childmatka->hasExecutor($actor->getId())) {
//            $childmatka->assignExecutor($actor);
//        }


        $childmatka->perewodPlem($actor, new \DateTimeImmutable());

        $this->flusher->flush();
    }
}

