<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Rasas\Linias\Nomers\Ojidaet\OjidaetActive;

use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\NomerRepository;
use App\Model\Flusher;


class Handler
{
    private $nomers;
    private $flusher;

    public function __construct(NomerRepository $nomers, Flusher $flusher)
    {
        $this->nomers = $nomers;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $nomer = $this->nomers->get(new Id($command->id));


        $nomer->ojidaetActive();

        $this->flusher->flush();
    }
}