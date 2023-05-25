<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\PlemMatka\Uchastnik\Add;

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

class Handler
{
    private $plemmatkas;
    private $uchasties;
    private $roles;
    private $flusher;

    public function __construct(
        PlemMatkaRepository $plemmatkas,
        UchastieRepository $uchasties,
        RoleRepository $roles,
        Flusher $flusher
    )
    {
        $this->plemmatkas = $plemmatkas;
        $this->uchasties = $uchasties;
        $this->roles = $roles;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $plemmatka = $this->plemmatkas->get(new Id($command->plemmatka));

//        $uchastie = $this->uchasties->get(new UchastieId($plemmatka->getUchastieId()));

        $uchastie = $this->uchasties->get(new UchastieId($command->uchastie));


        $departments = array_map(static function (string $id): DepartmentId {
            return new DepartmentId($id);
        }, $command->departments);

        $roles = array_map(function (string $id): Role {
            return $this->roles->get(new RoleId($id));
        }, $command->roles);

        $plemmatka->addUchastie($uchastie, $departments, $roles);

        $this->flusher->flush();
    }
}

