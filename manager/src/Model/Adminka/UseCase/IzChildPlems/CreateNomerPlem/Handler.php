<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\IzChildPlems\CreateNomerPlem;

use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Id as ChildId;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Status;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
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
    private $childmatkas;
    private $nomerRepository; //  основа для плем матки
    private $flusher;

    public function __construct(PlemMatkaRepository $plemmatkas,
                                    ChildMatkaRepository $childmatkas,
                                    NomerRepository $nomerRepository,
                                    Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
        $this->childmatkas = $childmatkas;
        $this->nomerRepository=$nomerRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $nomer = $this->nomerRepository->get(new NomerId($command->nomer));

        $childId = (int)$nomer->getVetkaNomer();

        $childmatka = $this->childmatkas->get(new ChildId( $childId));



        $persona =  $childmatka->getPlemMatka()->getPersona();
//        dd($persona);
        $mesto = $childmatka->getPlemMatka()->getMesto();

        $kategoria =  $childmatka->getPlemMatka()->getKategoria();

        $otecNomer = $childmatka->getOtecNomer();

//        $status = $childmatka->changeType()
//        getStatus();


//        $nameG = explode("-", $nomer->getName());

        $godaVixod =  $childmatka->getGodaVixod();

        $nom = explode("_", $nomer->getTitle());

        $namee = $nom[0]."_".$command->sort." : ".
            $nomer->getLinia()->getNameStar()."-".$nomer->getName().
                            " : ".$mesto->getNomer()."_пн-".$persona->getNomer();
//        dd( $namee);
        $command->name = $namee;
        if ($this->plemmatkas->hasByName($namee)) {
            throw new \DomainException('ПлемМатка  уже существует.');
        }

       
$plemmatka = new PlemMatka(
            Id::next(),
            $command->name,
            $command->sort,
            $command->title = "...",
            $godaVixod,
            $mesto,
            $nomer,
            $persona,
            $kategoria,
            $otecNomer
        );

        $this->plemmatkas->add($plemmatka);

//        $uchaste = $this->uchastes->get(new UchastieId($command->uchaste));
//
//        if (!$childmatka->hasExecutor($uchaste->getId())) {
//            $childmatka->assignExecutor($uchaste);
//        }
//        $actor = (new UchastieId($command->uchastieId));

//    !!!!!!!!!!!    $childmatka->changeStatus($actor, new \DateTimeImmutable() , Status::REJECTED);

        $nomer->ojidaetActive();

        $this->flusher->flush();
    }
}
