<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\Edit;

use App\Model\Drevos\Entity\Rass\RasRepository;
use App\Model\Drevos\Entity\Rass\Id;
use App\Model\Drevos\Entity\Rass\LiniBr\Id as LiniaId;

use App\Model\Flusher;

class Handler
{
    private $rasas;
    private $flusher;

    public function __construct(RasRepository $rasas, Flusher $flusher)
    {
        $this->rasas = $rasas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $rasa = $this->rasas->get(new Id($command->rasa));

        $rasa->editLiniBr(new LiniaId($command->id),
										$command->name
        );

        $this->flusher->flush();
    }
}

