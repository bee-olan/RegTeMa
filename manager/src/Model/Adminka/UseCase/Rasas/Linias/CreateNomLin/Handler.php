<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Rasas\Linias\CreateNomLin;

use App\Model\Adminka\Entity\Rasas\Linias\LiniaRepository;

use App\Model\Adminka\Entity\Rasas\Linias\Nomers\NomerRepository;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id as NomerId;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Rasas\Linias\Id;
use App\Model\Adminka\Entity\Rasas\Id as RasaId;
use App\Model\Adminka\Entity\Rasas\RasaRepository;

class Handler
{
    private $rasas;
    private $linias;
    private $nomerRepas;
    private $flusher;

    public function __construct(RasaRepository $rasas,
                                LiniaRepository $linias,
                                NomerRepository $nomerRepas,
                                Flusher $flusher)
    {
        $this->rasas = $rasas;
        $this->linias = $linias;
        $this->nomerRepas = $nomerRepas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
//dd("handle -- CreateNomLin");
        $nomer = $this->nomerRepas->get(new NomerId($command->idNomer));
        $command->nameStar = $nomer->getNameStar();
        $rasa = $this->rasas->get(new RasaId($command->rasa));

        $command->title = $rasa->getName()."_".$nomer->getName();
        $vetka = $command->vetka ? $this->linias->get(new Id($command->vetka)) : null;

        if ($command->vetka) {
            $command->idVetka = $command->vetka;
//            dd( $command->idVetka);
            $vetka = $this->linias->get(new Id($command->vetka));
            $rasa->setVetkaChildOf($vetka);
        }

//        $command->title =
//        dd($vetka);

     $rasa->addLinia(
            Id::next(),
            $command->name ,
			$command->nameStar,
			$command->title,
			$command->idVetka,
			$command->sortLinia,
            $vetka
        );
//dd($command);
        $this->flusher->flush();
    }
}
