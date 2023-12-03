<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\NomerBrs\Edit;

use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\VetBrRepository;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\Id;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr\Id as NomBrId;

use App\Model\Flusher;

class Handler
{
    private $godas;
    private $vetkas;
    private $flusher;

    public function __construct(VetBrRepository $vetkas, GodaRepository $godas, Flusher $flusher)
    {
        $this->godas = $godas;
        $this->vetkas = $vetkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $vetka = $this->vetkas->get(new Id($command->vetka));

        $goda = $this->godas->get(new GodaId($command->god));
        $god = (string)$goda->getGod();

        $vetka->editNomerBr(new NomBrId($command->id),
                $command->nomBr ,
                $god
            );

        $this->flusher->flush();
    }
}

