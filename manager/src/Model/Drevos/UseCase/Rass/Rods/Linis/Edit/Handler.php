<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Edit;

use App\Model\Flusher;
use App\Model\Drevos\Entity\Rass\Rods\RodRepository;
use App\Model\Drevos\Entity\Rass\Rods\Id;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Id as LiniaId;

class Handler
{
    private $rodos;
    private $flusher;

    public function __construct(RodRepository $rodos, Flusher $flusher)
    {
        $this->rodos = $rodos;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $rodo = $this->rodos->get(new Id($command->rodo));

        $rodo->editLinia(new LiniaId($command->id),
										$command->name);

        $this->flusher->flush();
    }
}

