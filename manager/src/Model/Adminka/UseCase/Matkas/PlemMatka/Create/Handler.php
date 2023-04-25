<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\PlemMatka\Create;

use App\Model\Flusher;
//use App\Model\Mesto\Entity\InfaMesto\Id as MestoNomerId;
//use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;
//
//use App\Model\Adminka\Entity\Matkas\PlemMatka\Department\Id as DepartmentId;

use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Adminka\Entity\Matkas\PlemMatka\Id;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;

use App\Model\Adminka\Entity\Rasas\Linias\Nomers\NomerRepository;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id as NomerId;

//
use App\Model\Adminka\Entity\Matkas\Kategoria\KategoriaRepository;
use App\Model\Adminka\Entity\Matkas\Kategoria\Id as KategoriaId;
//
use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;
use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;

//use App\Model\Adminka\Entity\Uchasties\Personas\Id as PersonaId;
//use App\Model\Adminka\Entity\Uchasties\Personas\PersonaRepository;

class Handler
{
    private $plemmatkas;
//    private $godas;
    private $kategorias;
    private $personas;
    private $nomerRepository; //  основа для плем матки
    private $flusher;

    public function __construct(PlemMatkaRepository $plemmatkas,
                                    PersonaFetcher $personas,
                                    MestoNomerFetcher $mestoNomers,
//                                    GodaRepository $godas,
                                    KategoriaRepository $kategorias,
                                    NomerRepository $nomerRepository,
                                    Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
//        $this->godas = $godas;
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
//        $goda = $this->godas->get(new GodaId($command->goda));
        $kategoria = $this->kategorias->get(new KategoriaId($command->kategoria));

//        if ($this->plemmatkas->hasSortPerson($sort, $command->persona)) {
//            throw new \DomainException('ТАКОЙ номер есть в БД.');
//        }
        $nomer = $this->nomerRepository->get(new NomerId($command->nomer));

        $nameStar = explode("-", $nomer->getNameStar());

        $command->godaVixod = (int) $nameStar[1];
       dd(   $command->godaVixod);
        $nom = explode("_", $nomer->getTitle());




        $command->name = $nom[0]."_".$kategoria->getName()."_".$command->sort." : ".
                            $nom[1]."-".$nom[2].
                            " : пн-".$persona->getNomer()."_".
                            $mesto->getNomer()."_".$command->godaVixod;

        $plemmatka = new PlemMatka(
            Id::next(),
            $command->name,
            $command->sort,
            $command->title,
            $command->godaVixod,
            $mesto,
            $nomer,
            $persona,
            $kategoria

        );

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
