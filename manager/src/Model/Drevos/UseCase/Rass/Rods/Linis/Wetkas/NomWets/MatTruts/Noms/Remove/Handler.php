<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Remove;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\MatTrutRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Id;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Id as NomId;

use App\Model\Flusher;



class Handler
{
    private $mattruts;
    private $flusher;

    public function __construct(MatTrutRepository $mattruts, Flusher $flusher)
    {
        $this->mattruts = $mattruts;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $mattrut = $this->mattruts->get(new Id($command->mattrut));

        $mattrut->removeNom(new NomId($command->id));

        $this->flusher->flush();
    }
}

