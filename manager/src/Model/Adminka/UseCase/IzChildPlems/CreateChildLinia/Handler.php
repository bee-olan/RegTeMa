<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\IzChildPlems\CreateChildLinia;

use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Id as ChildId;
use App\Model\Adminka\Entity\Rasas\Linias\LiniaRepository;

use App\Model\Adminka\Entity\Rasas\Linias\Nomers\NomerRepository;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id as NomerId;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Rasas\Linias\Id;
use App\Model\Adminka\Entity\Rasas\Id as RasaId;
use App\Model\Adminka\Entity\Rasas\RasaRepository;
use App\ReadModel\Adminka\Rasas\Linias\LiniaFetcher;

class Handler
{
    private $childRepo;
    private $rasas;
    private $linias;
    private $nomerRepas;
    private $flusher;

    public function __construct(ChildMatkaRepository $childRepo,
                                RasaRepository $rasas,
                                LiniaFetcher $linias,
                                NomerRepository $nomerRepas,
                                Flusher $flusher)
    {
        $this->childRepo = $childRepo;
//        $this->rasas = $rasas;
        $this->linias = $linias;
//        $this->nomerRepas = $nomerRepas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
       $childmatka = $this->childRepo->get(new ChildId($command->parent));

       $linia = $childmatka->getPlemMatka()->getNomer()->getLinia();

        $rasa = $linia->getRasa();

        $liniass = $this->linias->allOfRasLin($rasa->getId()->getValue());

        foreach ($liniass as $lini) {

            if ($lini['id_vetka'] == $linia->getId()->getValue()) {
                throw new \DomainException('Линия уже существует. Попробуйте для
                этой линии добавить свой номер!  из hand..');
                dd($lini);
            }
        }


       $vetka = $linia;
       $command->idVetka = $linia->getId()->getValue();
       $command->name = $linia->getName();

       $nomer= $childmatka->getPlemMatka()->getNomer();
       $command->nameStar = $nomer->getNameStar();

       $command->title = $nomer->getTitle()."_".$nomer->getName();


        $command->sortLinia = $this->linias->getMaxSortLinia($rasa->getId()->getValue()) + 1;



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
