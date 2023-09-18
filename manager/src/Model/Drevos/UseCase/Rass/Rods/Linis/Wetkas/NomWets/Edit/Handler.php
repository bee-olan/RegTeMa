<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Edit;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\WetkaRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Id;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Id as NomWetId;

use App\Model\Flusher;

use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;


class Handler
{
    private $godas;
    private $wetkas;
    private $flusher;

    public function __construct(WetkaRepository $wetkas, GodaRepository  $godas, Flusher $flusher)
    {
        $this->godas = $godas;
        $this->wetkas = $wetkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $wetka = $this->wetkas->get(new Id($command->wetka));

        $goda = $this->godas->get(new GodaId($command->godW));

        $godW = (string)$goda->getGod();

        $command->titW = $command->nomW."-".$godW;

        $wetka->editNomWet(new NomWetId($command->id),
										$command->nomW,
										$godW ,
										$command->titW);

        $this->flusher->flush();
    }
}

