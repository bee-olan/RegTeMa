<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Rasa\Linia\Nomer\Remove;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Rasas\Rasa\Linia\Nomer\Id as NomerId;
use App\Model\Paseka\Entity\Rasas\Rasa\Linia\Id;
use App\Model\Paseka\Entity\Rasas\Rasa\Linia\LiniaRepository;

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

