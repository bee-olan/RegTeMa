<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Rasas\Linias\Remove;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Rasas\Linias\Id as LiniaId;
use App\Model\Adminka\Entity\Rasas\Id;
use App\Model\Adminka\Entity\Rasas\RasaRepository;

class Handler
{
    private $rasas;
    private $flusher;

    public function __construct(RasaRepository $rasas, Flusher $flusher)
    {
        $this->rasas = $rasas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $rasa = $this->rasas->get(new Id($command->rasa));

        $rasa->removeLinia(new LiniaId($command->id));

        $this->flusher->flush();
    }
}

