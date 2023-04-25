<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Linias\Nomers\Remove;

use App\Model\Flusher;
use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Id as NomerId;
use App\Model\Adminka\Entity\OtecForRas\Linias\Id;
use App\Model\Adminka\Entity\OtecForRas\Linias\LiniaRepository;

class Handler
{
    private $linias;
    private $flusher;

    public function __construct(LiniaRepository $linias, Flusher $flusher)
    {
        $this->linias = $linias;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $linia = $this->linias->get(new Id($command->linia));

        $linia->removeNomer(new NomerId($command->id));

        $this->flusher->flush();
    }
}

