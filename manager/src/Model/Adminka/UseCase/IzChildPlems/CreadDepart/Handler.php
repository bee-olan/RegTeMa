<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\IzChildPlems\CreadDepart;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Matkas\PlemMatka\Department\Id;
use App\Model\Adminka\Entity\Matkas\PlemMatka\Id as PlemMatkaId;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\ReadModel\Adminka\Matkas\PlemMatka\DepartmentFetcher;

class Handler
{
    private $plemmatkas;
    private $departments;
    private $flusher;

    public function __construct(DepartmentFetcher $departments, PlemMatkaRepository $plemmatkas, Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
        $this->departments = $departments;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $plemmatka = $this->plemmatkas->get(new PlemMatkaId($command->plemmatka));

       $nach = $plemmatka->getGodaVixod()+ count($plemmatka->getDepartments());
//        $nach =$command->name;
            $name = $nach."-".($nach +1);

            $plemmatka->addDepartment(
                Id::next(),
                $name
            );


        $this->flusher->flush();
    }
}
