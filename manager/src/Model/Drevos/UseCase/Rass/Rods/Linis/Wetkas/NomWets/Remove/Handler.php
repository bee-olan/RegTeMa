<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Remove;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\WetkaRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Id;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Id as NomWetId;

use App\Model\Flusher;



class Handler
{
    private $wetkas;
    private $flusher;

    public function __construct(WetkaRepository $wetkas, Flusher $flusher)
    {
        $this->wetkas = $wetkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $wetka = $this->wetkas->get(new Id($command->wetka));

        $wetka->removeNomWet(new NomWetId($command->id));

        $this->flusher->flush();
    }
}

