<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\NomerBrs\Create;

use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\VetBrRepository;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\Id as VetBrId;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr\Id;

use App\Model\Flusher;


class Handler
{
    private $godas;
    private $vetkas;
    private $flusher;

    public function __construct( VetBrRepository $vetkas, GodaRepository $godas, Flusher $flusher)
    {
        $this->godas = $godas;
        $this->vetkas = $vetkas;
        $this->flusher = $flusher;
    }
    public function handle(Command $command): void
    {

        $vetka = $this->vetkas->get(new VetBrId($command->vetka));
        $god_vetka = $vetka->getGod();

        $goda = $this->godas->get(new GodaId($command->god));
        $god = (string)$goda->getGod();

        if ( (int)$goda->getGod() < (int)$god_vetka ){
            throw new \DomainException('Внимание! Исправьте год выхода матки. Дочь не может быть старше матери .');
        }

        $command->title = $command->nomBr."-".$god;

        $vetka->addNomerBr(
            Id::next(),
            $command->nomBr ,
            $god,
            $command->sortNom,
            $command->title
        );
//        dd($command);
        $this->flusher->flush();
    }
}
