<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\Create;

use App\Model\Drevos\Entity\Rass\Rods\Linis\LiniRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Id as LiniaId;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Id;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\WetkaRepository;
use App\Model\Flusher;

use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;

class Handler
{
    private $godas;
    private $linias;
    private $wetkaRepos;
    private $flusher;

    public function __construct(LiniRepository $linias,
                                GodaRepository $godas,
                                WetkaRepository $wetkaRepos,
                                Flusher $flusher)
    {
        $this->godas = $godas;
        $this->linias = $linias;
        $this->wetkaRepos = $wetkaRepos;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $linia = $this->linias->get(new LiniaId($command->linia));

        if ( $this->wetkaRepos->hasWetka($command->nameW)){

            $wetkaRepos= $this->wetkaRepos->getWetkaId($command->nameW);
            $command->id = $wetkaRepos;

        } else {

            $linia->addWetka(
                $command->id = Id::next(),
                $command->nameW ,
                $command->sortWetka

            );
        }


        $this->flusher->flush();
    }
}
