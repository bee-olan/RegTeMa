<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Edit;

use App\Model\Flusher;
use App\Model\Adminka\Entity\OtecForRas\Id;
use App\Model\Adminka\Entity\OtecForRas\RasaOtecRepository;

class Handler
{
    private $rasas;
    private $flusher;

    public function __construct(RasaOtecRepository $rasas, Flusher $flusher)
    {
        $this->rasas = $rasas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $rasa =$this->rasas->get(new Id($command->id));
        $rasa->edit($command->name, $command->title);

        $this->flusher->flush();
    }
}
