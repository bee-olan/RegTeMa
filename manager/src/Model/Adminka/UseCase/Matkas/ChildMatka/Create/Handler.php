<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\ChildMatka\Create;

use App\Model\Flusher;
use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;
use App\Model\Mesto\Entity\InfaMesto\Id as MestoNomerId;
use App\Model\Adminka\Entity\Uchasties\Personas\PersonaRepository;
use App\Model\Adminka\Entity\Uchasties\Personas\Id as PersonaId;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;

use App\Model\Adminka\Entity\Matkas\PlemMatka\Id as PlemMatkaId;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatkaRepository;

use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatka;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Id;
use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Type;


class Handler
{
    private $uchasties;
    private $plemmatkas;
    private $childmatkas;
    private $personas;
    private $mestonomers;
    private $flusher;

    public function __construct(
            UchastieRepository $uchasties, 
            PlemMatkaRepository $plemmatkas, 
            ChildMatkaRepository $childmatkas,
            PersonaRepository $personas,
            MestoNomerRepository $mestonomers,
            Flusher $flusher)
    {
        $this->uchasties = $uchasties;
        $this->plemmatkas = $plemmatkas;
        $this->childmatkas = $childmatkas;
        $this->personas=$personas;
        $this->mestonomers=$mestonomers;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
//
        $parent = $command->parent ? $this->childmatkas->get(new Id((int)$command->parent)) : null;

        $uchastie = $this->uchasties->get(new UchastieId($command->uchastie));

        $persona = $this->personas->get(new PersonaId($command->uchastie));

        $mestonomer = $this->mestonomers->get(new MestoNomerId($command->uchastie));

        $plemmatka = $this->plemmatkas->get(new PlemMatkaId($command->plemmatka));




        $command->godaVixod = (int)$command->plan_date->format('Y');

        $date = new \DateTimeImmutable();
        $command->plan = $date;


        if ($parent) {
            $nameParents=explode(" ",$parent->getName() );
            $nameParent = $nameParents[0]."-".$parent->getId();
        }else {
            $plem=explode(" ",$plemmatka->getName() );
            $nameParent = $plem[0] ;
        }

       for ($i = 1; $i <= (int)$command->kolChild; $i++) {

            $childmatkaId = $this->childmatkas->nextId();
           $sezonPlem = $command->sezonPlem; // ??????
            $command->name = $nameParent." : ".$childmatkaId."-".$command->godaVixod."_пн-".$persona->getNomer();
//dd($command->name);

        $childmatka = new ChildMatka(
            $childmatkaId,
            $plemmatka,
            $uchastie,
            $command->plan_date,
            new Type($command->type),
            $command->priority,
            $command->name,
            $command->content,
            $command->kolChild ,
            $command->godaVixod,
            $sezonPlem,
            $command->sezonChild=null
        );


            if ($parent) {
                $childmatka->setChildOf($uchastie, $date, $parent);
            }

            if ($command->plan) {
                $childmatka->plan($uchastie, $date, $command->plan);
            }

            $this->childmatkas->add($childmatka);
        }
        $this->flusher->flush();
    }
}
