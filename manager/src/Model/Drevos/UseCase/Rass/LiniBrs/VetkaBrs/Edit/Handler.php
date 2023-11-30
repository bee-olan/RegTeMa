<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\Edit;

//use App\Model\Drevos\Entity\Rass\RasRepository;
//use App\Model\Drevos\Entity\Rass\Id;
//use App\Model\Drevos\Entity\Rass\LiniBr\Id as LiniaId;
use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;
use App\Model\Drevos\Entity\Rass\LiniBr\Id ;
use App\Model\Drevos\Entity\Rass\LiniBr\Id as LiniBrId;
use App\Model\Drevos\Entity\Rass\LiniBr\LiniBrRepository;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\Id as VetkaBrId;

use App\Model\Flusher;

class Handler
{
    private $linias;
    private $godas;
    private $flusher;

    public function __construct(LiniBrRepository $linias, GodaRepository $godas, Flusher $flusher)
    {
        $this->linias = $linias;
        $this->godas = $godas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $linia = $this->linias->get(new LiniBrId($command->linia));

        $goda = $this->godas->get(new GodaId($command->god));
        $god = (string)$goda->getGod();

        $linia->editVetkaBr(new VetkaBrId($command->id),
										$command->nomer,
                                        $god
        );

        $this->flusher->flush();
    }
}

