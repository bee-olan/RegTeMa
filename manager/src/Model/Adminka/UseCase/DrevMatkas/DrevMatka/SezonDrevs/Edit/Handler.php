<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\SezonDrevs\Edit;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatkaRepository;
use App\Model\Flusher;
use App\Model\Adminka\Entity\DrevMatkas\Id ;
use App\Model\Adminka\Entity\DrevMatkas\SezonDrev\Id as SezonDrevId;


class Handler
{
    private $plemmatkas;
    private $flusher;

    public function __construct(DrevMatkaRepository $plemmatkas, Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $plemmatka = $this->plemmatkas->get(new Id($command->plemmatka));

        $plemmatka->editSezonDrev(new SezonDrevId($command->id), $command->name);

        $this->flusher->flush();
    }
}

