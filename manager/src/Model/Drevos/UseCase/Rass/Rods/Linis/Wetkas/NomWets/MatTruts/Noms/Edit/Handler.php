<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Edit;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\MatTrutRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Id;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Id as NomId;


use App\Model\Flusher;

use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;


class Handler
{
    private $godas;
    private $mattruts;
    private $flusher;

    public function __construct(MatTrutRepository $mattruts, GodaRepository  $godas, Flusher $flusher)
    {
        $this->godas = $godas;
        $this->mattruts = $mattruts;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $mattrut = $this->mattruts->get(new Id($command->mattrut));

        $goda = $this->godas->get(new GodaId($command->god));

        $god = (string)$goda->getGod();

        $command->tit = $command->nom."-".$god;

        $mattrut->editNom(new NomId($command->id),
										$command->nom,
										$god ,
										$command->tit
                            );

        $this->flusher->flush();
    }
}

