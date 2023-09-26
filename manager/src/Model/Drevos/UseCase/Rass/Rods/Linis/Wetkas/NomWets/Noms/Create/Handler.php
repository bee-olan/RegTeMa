<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Noms\Create;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Noms\Id;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWetRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Id as NomWetId;
use App\Model\Flusher;

use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;

class Handler
{
    private $godas;
    private $nomwets;
    private $flusher;

    public function __construct(NomWetRepository $nomwets, GodaRepository $godas, Flusher $flusher)
    {
        $this->godas = $godas;
        $this->nomwets = $nomwets;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $nomwet = $this->nomwets->get(new NomWetId($command->nomwet));

        $goda = $this->godas->get(new GodaId($command->god));

        $god = (string)$goda->getGod();

        $command->tit = $command->nom."-".$god;

     $nomwet->addNom(
         $command->id = Id::next(),
			$command->nom,
			$god,
			$command->tit,
			$command->nameOt,
			$command->sortNom
        );

        $this->flusher->flush();
    }
}