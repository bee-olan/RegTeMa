<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\IzChildPlems\CreateAssign;

use App\Model\Adminka\Entity\Matkas\ChildMatka\Id as ChildId;
use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Flusher;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\Model\Adminka\Entity\Matkas\PlemMatka\Id;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Adminka\Entity\Matkas\Role\Role;
use App\Model\Adminka\Entity\Matkas\Role\Id as RoleId;
use App\Model\Adminka\Entity\Matkas\Role\RoleRepository;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Adminka\Entity\Matkas\PlemMatka\Department\Id as DepartmentId;
use App\ReadModel\Adminka\Matkas\PlemMatka\DepartmentFetcher;

class Handler
{
    private $plemmatkas;
    private $uchasties;
    private $roles;
    private $childmatkas;
    private $departFetcher;
    private $flusher;

    public function __construct(
        PlemMatkaRepository $plemmatkas,
        UchastieRepository $uchasties,
        RoleRepository $roles,
        ChildMatkaRepository $childmatkas,
        DepartmentFetcher $departFetcher,
        Flusher $flusher
    )
    {
        $this->plemmatkas = $plemmatkas;
        $this->uchasties = $uchasties;
        $this->roles = $roles;
        $this->childmatkas = $childmatkas;
        $this->departFetcher = $departFetcher;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $childmatka =  $this->childmatkas->get(new ChildId($command->childId)) ;
       $sezonPlem = $childmatka->getSezonPlem();

        $starPlemId = $childmatka->getPlemMatka()->getId()->getValue();
        $starPlem = $this->plemmatkas->get(new Id($starPlemId));



        $plemmatka = $this->plemmatkas->get(new Id($command->plemmatka));



        $uchastieId = $childmatka->getAuthor()->getId()->getValue();
        $uchastie = $this->uchasties->get(new UchastieId($uchastieId));

        $departmentss = $this->departFetcher->allPlemSezon($plemmatka->getId()->getValue(), $sezonPlem );
        $id = (new DepartmentId($departmentss[0]['id']));
        $options = [];
        $newPlemId = new Id($plemmatka->getId()->getValue());
        $command->departments = array_flip($this->departFetcher->listOfPlemMatka($options['$newPlemId']));

        $departments = array_map(static function (string $id): DepartmentId {
            return new DepartmentId($id);
        }, $command->departments);

//dd(  $departments );




        $roles =  $starPlem->getUchastnik(new UchastieId($uchastieId))->getRoles();
//
//            array_map(function (string $id): Role {
//            return $this->roles->get(new RoleId($id));
//        }, $command->roles);

        $plemmatka->addUchastie($uchastie, $departments, $roles);

        $this->flusher->flush();
    }
}

