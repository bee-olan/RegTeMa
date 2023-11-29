<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Linias\Remove;

use App\Model\Adminka\Entity\OtecForRas\Linias\LiniaRepository;
use App\Model\Flusher;
use App\Model\Adminka\Entity\OtecForRas\Linias\Id ;


class Handler
{
    private $linis;
    private $flusher;

    public function __construct(LiniaRepository $linis, Flusher $flusher)
    {
        $this->linis = $linis;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
//        $lini = $this->linis->get(new Id($command->lini));
//
//        $lini->removeLinia(new LiniaId($command->id));

        $lini = $this->linis->get(new Id($command->id));

        $this->linis->remove($lini);

        $this->flusher->flush();
    }
}

