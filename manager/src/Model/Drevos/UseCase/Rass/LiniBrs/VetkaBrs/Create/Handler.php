<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\Create;

use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;

use App\Model\Drevos\Entity\Rass\LiniBr\LiniBrRepository;
use App\Model\Drevos\Entity\Rass\LiniBr\Id as LiniBrId;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\Id;

use App\Model\Flusher;

class Handler
{
    private $godas;
    private $linias;
    private $flusher;

    public function __construct(LiniBrRepository $linias, GodaRepository $godas, Flusher $flusher)
    {
        $this->godas = $godas;
        $this->linias = $linias;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $linia = $this->linias->get(new LiniBrId($command->linia));

        $goda = $this->godas->get(new GodaId($command->god));
        $god = (string)$goda->getGod();

//        $command->name =  $command->name;
//        $command->title = $command->title."_".$command->nameStar;
//        $vetka = $command->vetka = null;


     $linia->addVetkaBr(
            Id::next(),
            $command->nomer ,
			$god,
			$command->sortVet

        );
//     dd($command);
        $this->flusher->flush();
    }
}
