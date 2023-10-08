<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Create;

use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchatieId;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Id;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWetRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Id as NomWetId;
use App\Model\Flusher;

use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;

class Handler
{

    private $nomwets;
    private $flusher;

    public function __construct(NomWetRepository $nomwets,
                                Flusher $flusher)
    {
        $this->nomwets = $nomwets;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $nomwet = $this->nomwets->get(new NomWetId($command->nomwet));



     $nomwet->addMatTrut(
         $command->id = Id::next(),
			$command->nameOt,
			$command->sortTrut
        );

        $this->flusher->flush();
    }
}
