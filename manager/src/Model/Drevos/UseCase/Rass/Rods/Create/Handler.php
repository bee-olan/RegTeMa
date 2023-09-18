<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Create;

use App\Model\Drevos\Entity\Rass\RasRepository;
use App\Model\Drevos\Entity\Rass\Id as RasId;
use App\Model\Drevos\Entity\Strans\StranRepository;
use App\Model\Drevos\Entity\Strans\Id as StranId;

use App\Model\Drevos\Entity\Rass\Rods\Id;

use App\Model\Flusher;


class Handler
{
    private $rasas;
    private $stranas;
    private $flusher;

    public function __construct(RasRepository $rasas,
                                StranRepository $stranas,
                                Flusher $flusher)
    {
        $this->rasas = $rasas;
        $this->stranas = $stranas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $rasa = $this->rasas->get(new RasId($command->rasa));

        $strana = $this->stranas->get(new StranId($command->strana));


     $rasa->addRod(
            $command->id = Id::next(),
			$command->sortRodo,
            $command->nameMatkov,
            $command->kodMatkov,
            $strana
        );

        $this->rasas->add($rasa);

        $this->flusher->flush();
    }
}
