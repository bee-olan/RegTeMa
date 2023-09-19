<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\Create;

use App\Model\Drevos\Entity\Rass\Rods\Linis\LiniRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Id as LiniaId;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Id;
use App\Model\Flusher;

use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;

class Handler
{
    private $godas;
    private $linias;
    private $flusher;

    public function __construct(LiniRepository $linias, GodaRepository $godas, Flusher $flusher)
    {
        $this->godas = $godas;
        $this->linias = $linias;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $linia = $this->linias->get(new LiniaId($command->linia));

     $linia->addWetka(
            $command->id = Id::next(),
            $command->nameW ,
			$command->sortWetka

        );
        $this->flusher->flush();
    }
}
