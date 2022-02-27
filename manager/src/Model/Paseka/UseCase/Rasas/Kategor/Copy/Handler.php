<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Kategor\Copy;

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
        $current = $this->kategors->get(new Id($command->id));

        if ($this->kategors->hasByName($command->name)) {
            throw new \DomainException('Kategor already exists.');
        }

        $kategor = $current->clone(
            Id::next(),
            $command->name
        );

        $this->kategors->add($kategor);

        $this->flusher->flush();
    }
}
