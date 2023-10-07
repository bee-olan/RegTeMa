<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Noms\Create;

use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchatieId;

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
//    private $uchasties;
    private $flusher;

    public function __construct(NomWetRepository $nomwets,
                                GodaRepository $godas,
//                                UchastieRepository $uchasties,
                                Flusher $flusher)
    {
        $this->godas = $godas;
        $this->nomwets = $nomwets;
//        $this->uchasties= $uchasties;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $nomwet = $this->nomwets->get(new NomWetId($command->nomwet));

//        $zakazal = $this->uchasties->get(new UchatieId($command->zakazal));
//dd($zakazal->getName());
        $goda = $this->godas->get(new GodaId($command->god));

        $god = (string)$goda->getGod();

        $command->tit = $command->nom."-".$god;

     $nomwet->addNom(
         $command->id = Id::next(),
			$command->nom,
			$god,
			$command->tit,
			$command->nameOt,
			$command->sortNom,
            $command->zakazal
        );

        $this->flusher->flush();
    }
}
