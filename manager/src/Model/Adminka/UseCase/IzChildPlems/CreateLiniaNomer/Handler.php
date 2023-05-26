<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\IzChildPlems\CreateLiniaNomer;

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
        // $this->linia = $linias;
        $this->linias = $linias;
        $this->flusher = $flusher;
    }
    public function handle(Command $command): void
    {



        $linia = $this->linias->get(new LiniaId($command->linia));


//if ($linia->getVetka()){

    $names = explode("-",$command->name );

    $command->vetkaNomer = $command->name;
    $command->vetkaNomer = $names[0];

    $command->nameStar  = $linia->getNameStar()."-".$command->vetkaNomer;

//        dd( $command->nameStar);
        $command->title = $linia->getTitle();

        $linia->addNomer(
            Id::next(),
            $command->name ,
            $command->nameStar,
            $command->title,
            $command->sortNomer,
            $command->vetkaNomer
        );

        $this->flusher->flush();
    }
}