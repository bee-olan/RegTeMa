<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Linias\Nomers\Create;

use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Matka;
use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Otec;
use App\Model\Flusher;

use App\Model\Adminka\Entity\OtecForRas\Linias\LiniaRepository;
use App\Model\Adminka\Entity\OtecForRas\Linias\Id as LiniaId;

use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Id;

class Handler
{
    private $linias;
    private $flusher;

    public function __construct( LiniaRepository $linias, Flusher $flusher)
    {
        $this->linias = $linias;
        $this->flusher = $flusher;
    }
    public function handle(Command $command): void
    {

        $linia = $this->linias->get(new LiniaId($command->linia));

        $linia->addNomer(
            Id::next(),
            $command->name ,
            new Matka(
                $command->matkaLinia,
                $command->matkaNomer
            ),
            new Otec(
                $command->otecLinia,
                $command->otecNomer
            ),
            $command->oblet,
            $command->title
        );

        $this->flusher->flush();
    }
}
