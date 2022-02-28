<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Rasa\Pcheloship\Add;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Rasas\Rasa\Linia\Id as LiniaId;
use App\Model\Paseka\Entity\Rasas\Rasa\Id;
use App\Model\Paseka\Entity\Rasas\Rasa\RasaRepository;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\PchelowodRepository;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Id as PchelowodId;
use App\Model\Paseka\Entity\Rasas\Kategor\Id as KategorId;
use App\Model\Paseka\Entity\Rasas\Kategor\Kategor;
use App\Model\Paseka\Entity\Rasas\Kategor\KategorRepository;

class Handler
{
    private $rasas;
    private $pchelowods;
    private $kategors;
    private $flusher;

    public function __construct(
        RasaRepository $rasas,
        PchelowodRepository $pchelowods,
        KategorRepository $kategors,
        Flusher $flusher
    )
    {
        $this->rasas = $rasas;
        $this->pchelowods = $pchelowods;
        $this->kategors = $kategors;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $rasa = $this->rasas->get(new Id($command->rasa));
        $pchelowod = $this->pchelowods->get(new PchelowodId($command->pchelowod));

        $linias = array_map(static function (string $id): LiniaId {
            return new LiniaId($id);
        }, $command->linias);

        $kategors = array_map(function (string $id): Kategor {
            return $this->kategors->get(new KategorId($id));
        }, $command->kategors);

        $rasa->addPchelowod($pchelowod, $linias, $kategors);

        $this->flusher->flush();
    }
}

