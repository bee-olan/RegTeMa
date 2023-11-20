<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\Create;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\DrevMatka;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\DrevMatkaRepository;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\Id;
use App\Model\Adminka\Entity\Uchasties\Personas\PersonaRepository;
use App\Model\Adminka\Entity\Uchasties\Personas\Id as PersonaId;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\NomRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Id as NomerId;;
use App\Model\Flusher;
use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;
use App\Model\Mesto\Entity\InfaMesto\Id as MestoNomerId;

class Handler
{
    private $drevmatkas;
    private $nomerRepository; //  основа для плем матки
    private $personas;
    private $mestoNomers;
    private $flusher;

    public function __construct(DrevMatkaRepository $drevmatkas,
                                    PersonaRepository $personas,
                                    MestoNomerRepository  $mestoNomers,
                                    NomRepository $nomerRepository,
                                    Flusher $flusher)
    {
        $this->drevmatkas = $drevmatkas;
        $this->personas = $personas;
        $this->mestoNomers=$mestoNomers;
        $this->nomerRepository=$nomerRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $nomer = $this->nomerRepository->get(new NomerId($command->nomer));
        $nameDr = $nomer->miniDrevMat();

        $nomer->getZakazal();

        $persona = $this->personas->get(new PersonaId($nomer->getZakazal()->getId()->getValue()));
           $personNom = $persona->getNomer();

        $mesto = $this->mestoNomers->get(new MestoNomerId($nomer->getZakazal()->getId()->getValue()));
         $mestoNom = $mesto->getNomer();

         $command->name = $mestoNom."_пн-".$personNom." : ".$nameDr;
//         dd($name);
        if ($this->drevmatkas->hasByName($command->name)) {
            throw new \DomainException('ПлемМатка  уже существует.');
        }

       
$drevmatka = new DrevMatka(
            Id::next(),
            $command->name,
            $command->sort,
            $mesto,
            $nomer,
            $persona
        );

        $this->drevmatkas->add($drevmatka);


        $nomer->ojidaetActive();

        $this->flusher->flush();
    }
}
