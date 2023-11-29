<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\Create;


use App\Model\Drevos\Entity\Rass\LiniBr\LiniBrRepository;
use App\Model\Drevos\Entity\Rass\LiniBr\Id as LiniBrId;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\Id;

use App\Model\Flusher;

class Handler
{
    private $linias;
    private $flusher;

    public function __construct(LiniBrRepository $linias, Flusher $flusher)
    {
        $this->linias = $linias;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $linia = $this->linias->get(new LiniBrId($command->linia));

//        $command->name =  $command->name;
//        $command->title = $command->title."_".$command->nameStar;
//        $vetka = $command->vetka = null;


     $linia->addVetkaBr(
            Id::next(),
            $command->nomer ,
			$command->god,
			$command->sortVet

        );
//     dd($command);
        $this->flusher->flush();
    }
}
