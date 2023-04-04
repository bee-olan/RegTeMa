<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\ChildMatka\Type;

use App\Model\Flusher;

use App\Model\Adminka\Entity\Matkas\ChildMatka\Id;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Type;
use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;

class Handler
{
    private $uchasties;
    private $childmatkas;
    private $flusher;

    public function __construct(UchastieRepository $uchasties,
                                ChildMatkaRepository $childmatkas, Flusher $flusher)
    {
        $this->uchasties = $uchasties;
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $actor = $this->uchasties->get(new UchastieId($command->actor));
        $childmatka = $this->childmatkas->get(new Id($command->id));

//        $childmatka->changeType($actor, new \DateTimeImmutable(),new Type($command->type));

        $childmatka->changeType(
            $actor,
            new \DateTimeImmutable(),
            new Type($command->type)
        );

        $this->flusher->flush();

    }
}
