<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Rasa\Pcheloship\Remove;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Rasas\Rasa\Id;
use App\Model\Paseka\Entity\Rasas\Rasa\RasaRepository;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\PchelowodRepository;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Id as PchelowodId;

class Handler
{
    private $rasas;
    private $flusher;
    private $pchelowods;

    public function __construct(
        RasaRepository $rasas,
        PchelowodRepository $pchelowods,
        Flusher $flusher
    )
    {
        $this->rasas = $rasas;
        $this->flusher = $flusher;
        $this->pchelowods = $pchelowods;
    }

    public function handle(Command $command): void
    {
        $kategor = $this->kategors->get(new Id($command->id));

        if ($this->rasas->hasPchelowodsWithKategor($kategor->getId())) {
            throw new \DomainException('Kategor contains pchelowods.');
        }

        $this->kategors->remove($kategor);

        $this->flusher->flush();
    }
}

