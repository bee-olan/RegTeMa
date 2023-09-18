<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Create;

use App\Model\Flusher;

use App\Model\Drevos\Entity\Rass\Rods\RodRepository;
use App\Model\Drevos\Entity\Rass\Rods\Id as RodoId;;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Id ;

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
        $rodo = $this->rodos->get(new RodoId($command->rodo));




     $rodo->addLini(
            $command->id = Id::next(),
            $command->name ,
			$command->sortLini
        );
        $this->flusher->flush();
    }
}
