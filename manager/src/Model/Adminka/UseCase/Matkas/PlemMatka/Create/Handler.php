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
    private $personas;
    private $nomerRepository; //  основа для плем матки
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

//        if ($this->plemmatkas->hasSortPerson($sort, $command->persona)) {
//            throw new \DomainException('ТАКОЙ номер есть в БД.');
//        }
        $nomer = $this->nomerRepository->get(new NomerId($command->nomer));
//        dd($nomer);
        $nameG = explode("-", $nomer->getName());

        $command->godaVixod = (int) $nameG[1];
//
        $nom = explode("_", $nomer->getTitle());




        $command->name = $nom[0]."_".$command->sort." : ".
            $nomer->getLinia()->getNameStar()."-".$nomer->getName().
                            " : ".$mesto->getNomer()."_пн-".$persona->getNomer();

        $plemmatka = new PlemMatka(
            Id::next(),
            $command->name,
            $command->sort,
            $command->title,
            $command->godaVixod,
            $mesto,
            $nomer,
            $persona,
            $kategoria,
            $otecNomer
        );
//dd($plemmatka);
        $this->plemmatkas->add($plemmatka);

//        $nach = $plemmatka->getGodaVixod()+ count($plemmatka->getDepartments());
//
//        $command->name = $nach." - ".($nach +1);
//        $plemmatka->addDepartment(
//            DepartmentId::next(),
//            $command->name
//        );

        $this->flusher->flush();
    }
}
