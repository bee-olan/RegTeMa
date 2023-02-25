<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Rasas\Linias\Create;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Rasas\Linias\Id;
use App\Model\Adminka\Entity\Rasas\Id as RasaId;
use App\Model\Adminka\Entity\Rasas\RasaRepository;

class Handler
{
    private $rasas;
    private $flusher;

    public function __construct(RasaRepository $rasas, Flusher $flusher)
    {
        $this->rasas = $rasas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $rasa = $this->rasas->get(new RasaId($command->rasa));

     $rasa->addLinia(
            Id::next(),
            $command->name ,
			$command->nameStar,
			$command->title,
			$command->sortLinia
        );
        $this->flusher->flush();
    }
}
