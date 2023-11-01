<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Ojidaet\OjidaetActive;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\NomRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Id;
use App\Model\Flusher;


class Handler
{
    private $nomers;
    private $flusher;

    public function __construct(NomRepository $nomers, Flusher $flusher)
    {
        $this->nomers = $nomers;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $nomer = $this->nomers->get(new Id($command->id));


        $nomer->ojidaetActive();

        $this->flusher->flush();
    }
}