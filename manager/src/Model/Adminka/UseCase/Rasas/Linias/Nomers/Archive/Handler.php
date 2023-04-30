<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Rasas\Linias\Nomers\Archive;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\NomerRepository;
use App\Model\Flusher;


class Handler
{
    private $nomerss;
    private $flusher;

    public function __construct(NomerRepository $nomers, Flusher $flusher)
    {
        $this->nomers = $nomers;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $nomer = $this->nomers->get(new Id($command->id));


        $nomer->archive();

        $this->flusher->flush();
    }
}