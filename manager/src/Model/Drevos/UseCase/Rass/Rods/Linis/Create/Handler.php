<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Create;


use App\Model\Drevos\Entity\Rass\Rods\Linis\LiniRepository;
use App\Model\Flusher;

use App\Model\Drevos\Entity\Rass\Rods\RodRepository;
use App\Model\Drevos\Entity\Rass\Rods\Id as RodoId;;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Id ;

class Handler
{
    private $rodos;
    private $liniaRepos;
    private $flusher;

    public function __construct(RodRepository $rodos,
                                LiniRepository $liniaRepos,
                                Flusher $flusher)
    {
        $this->rodos = $rodos;
        $this->liniaRepos = $liniaRepos;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $rodo = $this->rodos->get(new RodoId($command->rodo));

        if ( $this->liniaRepos->hasLini($command->name)){

            $liniaRepos= $this->liniaRepos->getLiniId($command->name);
            $command->id = $liniaRepos;

        } else {

            $rodo->addLini(
                $command->id = Id::next(),
                $command->name ,
                $command->sortLini
            );
        }



        $this->flusher->flush();
    }
}
