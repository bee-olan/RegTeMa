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
//use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;
//use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;

//use App\Model\Adminka\Entity\Uchasties\Personas\Id as PersonaId;
//use App\Model\Adminka\Entity\Uchasties\Personas\PersonaRepository;

class Handler
{
    private $plemmatkas;
//    private $godas;
    private $kategorias;
    private $personas;
//    private $mestonomers;
    private $nomerRepository; //  основа для плем матки
    private $flusher;

    public function __construct(PlemMatkaRepository $plemmatkas,
                                    PersonaFetcher $personas,
                                    MestoNomerFetcher $mestoNomers,
//                                GodaRepository $godas,
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
//
        $kategoria = $this->kategorias->get(new KategoriaId($command->kategoria));
//dd($kategoria);


//        if ($this->plemmatkas->hasSortPerson($sort, $command->persona)) {
//            throw new \DomainException('ТАКОЙ номер есть в БД.');
//        }
        $nomer = $this->nomerRepository->get(new NomerId($command->nomer));
//dd($nomer);
        $nom = explode("_", $nomer->getTitle());

        $command->nameKateg = $kategoria->getName();

        $command->mesto = $mesto->getNomer();

        $command->persona = $persona->getNomer();
//        $command->rasaNomId = $mestonomer->getId()->getValue();
//        $command->godaVixod = (int)$goda->getGod();
        $command->godaVixod=2022;
        $command->name = $nom[0]."_".$command->nameKateg."_".$command->sort." : ".
            $nom[1]."-".$nom[2]." : пн".$command->persona."_".$command->mesto."_".$command->godaVixod;
//dd($command->name);
        $plemmatka = new PlemMatka(
            Id::next(),
            $command->name,
            $command->sort,
            $command->title,
            $command->godaVixod=2022,
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
