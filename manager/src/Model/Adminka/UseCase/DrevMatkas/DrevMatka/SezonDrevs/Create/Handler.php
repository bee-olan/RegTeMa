<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\SezonDrevs\Create;

use App\Model\Flusher;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\SezonDrev\Id ;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\DrevMatkaRepository;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\Id as DrevMatkaId;


use App\ReadModel\Adminka\DrevMatkas\SezonDrevFetcher;


class Handler
{
    private $plemmatkas;
    private $sezondrev;
    private $flusher;

    public function __construct(SezonDrevFetcher $sezondrev, DrevMatkaRepository $plemmatkas, Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
        $this->sezondrev = $sezondrev;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $plemmatka = $this->plemmatkas->get(new DrevMatkaId($command->plemmatka));


        $nach =$plemmatka->getNomer()->getGod() + count($plemmatka->getSezondrevs());

//        $nach =$command->name;
            $name = $nach."-".((int)$nach +1);

            $plemmatka->addSezonDrev(
                Id::next(),
                $name
            );


        $this->flusher->flush();
    }
}
