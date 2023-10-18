<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\Create;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatkaRepository;
use App\Model\Adminka\Entity\DrevMatkas\Id;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\NomRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Id as NomerId;;
use App\Model\Flusher;

use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;

//use App\Model\Adminka\Entity\Rasas\Linias\Nomers\NomerRepository;
//use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id as NomerId;
//use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\NomerRepository as OtNomerRepository;



class Handler
{
    private $drevmatkas;
    private $nomerRepository; //  основа для плем матки
    private $personas;
    private $mestoNomers;
    private $flusher;

    public function __construct(DrevMatkaRepository $drevmatkas,
                                    PersonaFetcher $personas,
                                    MestoNomerFetcher $mestoNomers,
                                    NomRepository $nomerRepository,
                                    Flusher $flusher)
    {
        $this->drevmatkas = $drevmatkas;

        $this->personas=$personas;
        $this->mestoNomers=$mestoNomers;
        $this->nomerRepository=$nomerRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $nomer = $this->nomerRepository->get(new NomerId($command->nomer));


        $persona = $this->personas->find($command->uchastieId);

        $mesto = $this->mestoNomers->find($command->uchastieId);

        $nameG = explode("-", $nomer->getName());

        $godaVixod = (int) $nameG[1];

        $nom = explode("_", $nomer->getTitle());

        $namee = $nom[0]."_".$command->sort." : ".
            $nomer->getLinia()->getNameStar()."-".$nomer->getName().
                            " : ".$mesto->getNomer()."_пн-".$persona->getNomer();
        $command->name = $namee;
        if ($this->plemmatkas->hasByName($namee)) {
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
