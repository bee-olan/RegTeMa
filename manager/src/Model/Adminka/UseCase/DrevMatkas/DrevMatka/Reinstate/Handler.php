<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\Reinstate;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\DrevMatkaRepository;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\Id;
use App\Model\Flusher;



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
        $plemmatka = $this->plemmatkas->get(new Id($command->id));

        $plemmatka->reinstate();

        $this->flusher->flush();
    }
}