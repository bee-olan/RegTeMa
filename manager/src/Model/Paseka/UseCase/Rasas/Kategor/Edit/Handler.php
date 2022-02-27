<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Kategor\Edit;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Rasas\Kategor\Id;
use App\Model\Paseka\Entity\Rasas\Kategor\KategorRepository;

class Handler
{
    private $kategors;
    private $flusher;

    public function __construct(KategorRepository $kategors, Flusher $flusher)
    {
        $this->kategors = $kategors;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $kategor = $this->kategors->get(new Id($command->id));

        $kategor->edit($command->name, $command->permissions);

        $this->flusher->flush();
    }
}
