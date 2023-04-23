<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Rasas\Linias\CreateNomLin;

use App\Model\Adminka\Entity\Rasas\Linias\LiniaRepository;
use App\Model\Flusher;
use App\Model\Adminka\Entity\Rasas\Linias\Id;
use App\Model\Adminka\Entity\Rasas\Id as RasaId;
use App\Model\Adminka\Entity\Rasas\RasaRepository;

class Handler
{
    private $rasas;
    private $linias;
    private $flusher;

    public function __construct(RasaRepository $rasas, LiniaRepository $linias, Flusher $flusher)
    {
        $this->rasas = $rasas;
        $this->linias = $linias;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $rasa = $this->rasas->get(new RasaId($command->rasa));

        $vetka = $command->vetka ? $this->linias->get(new Id($command->vetka)) : null;
//dd($vetka);

        if ($command->vetka) {
            $vetka = $this->linias->get(new Id($command->vetka));
            $rasa->setVetkaChildOf($vetka);
        }
//        dd($vetka);

     $rasa->addLinia(
            Id::next(),
            $command->name ,
			$command->nameStar,
			$command->title,
			$command->sortLinia,
            $vetka
        );

        $this->flusher->flush();
    }
}
