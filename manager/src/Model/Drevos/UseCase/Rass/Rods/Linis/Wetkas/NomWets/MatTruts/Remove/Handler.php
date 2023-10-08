<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Remove;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWetRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Id;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Id as MatTrutsId;

use App\Model\Flusher;



class Handler
{
    private $nomwets;
    private $flusher;

    public function __construct(NomWetRepository $nomwets, Flusher $flusher)
    {
        $this->nomwets = $nomwets;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $nomwet = $this->nomwets->get(new Id($command->nomwet));

        $nomwet->removeNom(new MatTrutsId($command->id));

        $this->flusher->flush();
    }
}

