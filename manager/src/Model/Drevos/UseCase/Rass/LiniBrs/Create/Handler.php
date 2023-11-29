<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\Create;

use App\Model\Drevos\Entity\Rass\RasRepository;
use App\Model\Drevos\Entity\Rass\Id as RasaId;
use App\Model\Flusher;
use App\Model\Drevos\Entity\Rass\LiniBr\Id;

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
        $rasa = $this->rasas->get(new RasaId($command->rasa));

//        $command->name =  $command->name;
//        $command->title = $command->title."_".$command->nameStar;
            $roditBr = $command->roditBr = null;


     $rasa->addLiniBr(
            Id::next(),
            $command->name ,
			$command->sortLiniBr,
            $roditBr
        );
//     dd($command);
        $this->flusher->flush();
    }
}
