<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\ChildMatka\Executor\Assign;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Id;
use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatkaRepository;

class Handler
{
    private $childmatkas;
    private $flusher;
    private $uchasties;

    public function __construct(
        ChildMatkaRepository $childmatkas,
        UchastieRepository $uchasties,
        Flusher $flusher
    )
    {
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
        $this->uchasties = $uchasties;
    }

    public function handle(Command $command): void
    {
        $actor = $this->uchasties->get(new UchastieId($command->actor));
        $childmatka = $this->childmatkas->get(new Id($command->id));

        foreach ($command->uchasties as $id) {
            $uchastie = $this->uchasties->get(new UchastieId($id));
            if (!$childmatka->hasExecutor($uchastie->getId())) {
                $childmatka->assignExecutor($actor, new \DateTimeImmutable(),$uchastie);
            }
        }

        $this->flusher->flush();
    }
}


