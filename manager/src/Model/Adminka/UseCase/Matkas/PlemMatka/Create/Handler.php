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

//use App\Model\Adminka\Entity\Rasas\Linias\Nomers\NomerRepository;
//use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id as NomerId;
//
//use App\Model\Adminka\Entity\Matkas\Sparings\SparingRepository;
//use App\Model\Adminka\Entity\Matkas\Sparings\Id as SparingId;
//
//use App\Model\Adminka\Entity\Matkas\Kategoria\KategoriaRepository;
//use App\Model\Adminka\Entity\Matkas\Kategoria\Id as KategoriaId;
//
//use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;
//use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;

//use App\Model\Adminka\Entity\Uchasties\Personas\Id as PersonaId;
//use App\Model\Adminka\Entity\Uchasties\Personas\PersonaRepository;

class Handler
{
    private $plemmatkas;
//    private $godas;
//    private $kategorias;
//    private $personas;
//    private $mestonomers;
//    private $nomerRepository; //  основа для плем матки
    private $flusher;

    public function __construct(PlemMatkaRepository $plemmatkas,
//                                GodaRepository $godas,
//                                KategoriaRepository $kategorias,
//                                PersonaRepository $personas,
//                                MestoNomerRepository $mestonomers,
//                                NomerRepository $nomerRepository,
                                Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
//        $this->godas = $godas;
//        $this->kategorias = $kategorias;
//        $this->personas=$personas;
//        $this->mestonomers=$mestonomers;
//        $this->nomerRepository=$nomerRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
//        $goda = $this->godas->get(new GodaId($command->goda));
//
//        $kategoria = $this->kategorias->get(new KategoriaId($command->kategoria));
//
//        $persona = $this->personas->get(new PersonaId($command->uchastieId));
//
//        $mestonomer = $this->mestonomers->get(new MestoNomerId($command->uchastieId));
//        dd($mestonomer->getNomer() );
//        if ($this->plemmatkas->hasSortPerson($sort, $command->persona)) {
//            throw new \DomainException('ТАКОЙ номер есть в БД.');
//        }
//        $nomer = $this->nomerRepository->get(new NomerId($command->nomerId));
//dd($nomer);
//        $nom = explode("_", $nomer->getTitle());
//
//        $command->nameKateg = $kategoria->getName();
////        $command->kategoriaId = $kategoria->getId()->getValue();
//        $command->mesto = $mestonomer->getNomer();
//        $command->persona = $persona->getNomer();
//        $command->rasaNomId = $mestonomer->getId()->getValue();
//        $command->godaVixod = (int)$goda->getGod();

//        $command->name = $nom[0]."_".$command->nameKateg."_".$command->sort." : ".
//            $nom[1]."-".$nom[2]." : пн".$command->persona."_".$command->mesto."_".$command->godaVixod;

        $plemmatka = new PlemMatka(
            Id::next(),
            $command->name,
            $command->sort,
            $command->title,
            $command->godaVixod=2022
//            $command->uchastieId
//            $command->mesto,
//            $command->persona,
//            $command->rasaNomId,

//            $command->nameKateg ,
//            $kategoria,


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
