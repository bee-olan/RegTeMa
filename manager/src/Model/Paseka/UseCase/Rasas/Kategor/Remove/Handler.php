<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Kategor\Remove;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Rasas\Rasa\RasaRepository;
use App\Model\Paseka\Entity\Rasas\Kategor\KategorRepository;
use App\Model\Paseka\Entity\Rasas\Kategor\Id;

class Handler
{
    private $kategors;
    private $rasas;
    private $flusher;

    public function __construct(KategorRepository $kategors, RasaRepository $rasas, Flusher $flusher)
    {

        $this->kategors = $kategors;
        $this->rasas = $rasas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $kategor = $this->kategors->get(new Id($command->id));

        if ($this->rasas->hasPchelowodsWithKategor($kategor->getId())) {
            throw new \DomainException('Kategor contains members.');
        }

        $this->kategors->remove($kategor);

        $this->flusher->flush();
    }
}
