<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Remove;

use App\Model\Drevos\Entity\Rass\RasRepository;
use App\Model\Drevos\Entity\Rass\Id;
use App\Model\Flusher;
use App\Model\Drevos\Entity\Rass\Rods\Id as RodoId;



class Handler
{
    private $rasas;
    private $flusher;

    public function __construct(RasRepository $rasas, Flusher $flusher)
    {
        $this->rasas = $rasas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $rasa = $this->rasas->get(new Id($command->rasa));

        $rasa->removeRod(new RodoId($command->id));

        $this->flusher->flush();
    }
}

