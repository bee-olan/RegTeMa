<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Kategor\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Rasas\Kategor\Kategor;
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
        if ($this->kategors->hasByName($command->name)) {
            throw new \DomainException('Kategor already exists.');
        }

        $kategor = new Kategor(
            Id::next(),
            $command->name,
            $command->permissions
        );

        $this->kategors->add($kategor);

        $this->flusher->flush();
    }
}
