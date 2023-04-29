<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Rasas\Linias\Nomers\Create;

use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\Model\Flusher;

use App\Model\Adminka\Entity\Rasas\Linias\LiniaRepository;
use App\Model\Adminka\Entity\Rasas\Linias\Id as LiniaId;

use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id;

class Handler
{
    private $linias;
    private $flusher;

    public function __construct( LiniaRepository $linias, Flusher $flusher)
    {
        $this->linia = $linias;
        $this->linias = $linias;
        $this->flusher = $flusher;
    }
    public function handle(Command $command): void
    {


//     +name: "4-2015"
//    +title: "Як"
//    +sortNomer: 1

        $linia = $this->linias->get(new LiniaId($command->linia));
//        dd($linia) ;
//        Linia^ {#1202 ▼
//        -rasa: Rasa^ {#1182 ▶}
//            -id: Id^ {#879 ▶}
//                -name: "Бикань"
//                -nameStar: "Бикань"
//                -title: "Як"
//                -nomers: PersistentCollection^ {#1148 ▶}
//                    -sortLinia: 1
//                    -vetka: null
//
        $command->title = $linia->getTitle();

        $names = explode("-",$command->name );
        $command->vetkaNomer = $names[0];

        $command->nameStar  = $linia->getNameStar()."-".$command->vetkaNomer;




        $linia->addNomer(
            Id::next(),
            $command->name ,
            $command->nameStar,
            $command->title,
            $command->sortNomer,
            $command->vetkaNomer
        );
//        dd($command);
        $this->flusher->flush();
    }
}
