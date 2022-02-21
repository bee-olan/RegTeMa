<?php

declare(strict_types=1);

namespace App\Model\Matkis\UseCase\Rasas\Rasa\Create;

use App\Model\Flusher;
use App\Model\Matkis\Entity\Rasas\Rasa\Rasa;
use App\Model\Matkis\Entity\Rasas\Rasa\Id;
use App\Model\Matkis\Entity\Rasas\Rasa\RasaRepository;

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
        $rasa = new Rasa(
            Id::next(),
            $command->name,
            $command->sort
        );

        $this->rasas->add($rasa);

        $this->flusher->flush();
    }
}