<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\Edit;

use App\Model\Flusher;
use App\Model\Drevos\Entity\Rass\Rods\Linis\LiniRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Id ;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Id as WetkaId;

class Handler
{
    private $linias;
    private $flusher;

    public function __construct(LiniRepository $linias, Flusher $flusher)
    {
        $this->linias = $linias;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $linia = $this->linias->get(new Id($command->linia));

        $linia->editWetka(new WetkaId($command->id),
										$command->nameW );

        $this->flusher->flush();
    }
}

