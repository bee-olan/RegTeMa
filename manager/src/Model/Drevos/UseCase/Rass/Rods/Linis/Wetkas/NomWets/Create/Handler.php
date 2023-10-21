<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Create;

use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Id;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\WetkaRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Id as WetkaId;
use App\Model\Flusher;


class Handler
{
    private $godas;
    private $wetkas;
    private $flusher;

    public function __construct(WetkaRepository $wetkas, GodaRepository $godas, Flusher $flusher)
    {
        $this->godas = $godas;
        $this->wetkas = $wetkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $wetka = $this->wetkas->get(new WetkaId($command->wetka));

        $goda = $this->godas->get(new GodaId($command->god));

        $godW = (string)$goda->getGod();

        $command->titW = $command->nomW."-".$godW;

//        if ( $this->liniaRepos->hasLini($command->name)){
//
//            $liniaRepos= $this->liniaRepos->getLiniId($command->name);
//            $command->id = $liniaRepos;
//
//        } else {
//
//            $rodo->addLini(
//                $command->id = Id::next(),
//                $command->name ,
//                $command->sortLini
//            );
//        }

     $wetka->addNomWet(
            $command->id =Id::next(),
			$command->nomW,
			$godW,
			$command->titW,
			$command->sortNomWet

        );
        $this->flusher->flush();
    }
}
