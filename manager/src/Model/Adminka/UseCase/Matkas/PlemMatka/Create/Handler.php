<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\PlemMatka\Create;

use App\Model\Flusher;

use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Adminka\Entity\Matkas\PlemMatka\Id;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;

use App\Model\Adminka\Entity\Rasas\Linias\Nomers\NomerRepository;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id as NomerId;
use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\NomerRepository as OtNomerRepository;
use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Id as OtecNomerId;
//
use App\Model\Adminka\Entity\Matkas\Kategoria\KategoriaRepository as KategoriaRepository;
use App\Model\Adminka\Entity\Matkas\Kategoria\Id as KategoriaId;


class Handler
{
    private $plemmatkas;
    private $otecNomers;
    private $kategorias;
    private $nomerRepository; //  основа для плем матки
    private $personas;
    private $mestoNomers;
    private $flusher;

    public function __construct(PlemMatkaRepository $plemmatkas,
                                    PersonaFetcher $personas,
                                    MestoNomerFetcher $mestoNomers,
                                    KategoriaRepository $kategorias,
                                    OtNomerRepository $otecNomers,
                                    NomerRepository $nomerRepository,
                                    Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
        $this->otecNomers = $otecNomers;
        $this->kategorias = $kategorias;
        $this->personas=$personas;
        $this->mestoNomers=$mestoNomers;
        $this->nomerRepository=$nomerRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $persona = $this->personas->find($command->uchastieId);

        $mesto = $this->mestoNomers->find($command->uchastieId);

        $kategoria = $this->kategorias->get(new KategoriaId($command->kategoria));

        $otecNomer = $this->otecNomers->get(new OtecNomerId($command->otecNomer));


        $nomer = $this->nomerRepository->get(new NomerId($command->nomer));

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

       
$plemmatka = new PlemMatka(
            Id::next(),
            $command->name,
            $command->sort,
            $command->title,
            $godaVixod,
            $mesto,
            $nomer,
            $persona,
            $kategoria,
            $otecNomer
        );

        $this->plemmatkas->add($plemmatka);

        $nomer->ojidaetActive();

        $this->flusher->flush();
    }
}
