<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Pchelowods\Pchelowod\Edit;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Email;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Id;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\PchelowodRepository;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Name;

class Handler
{
    private $pchelowods;
    private $flusher;

    public function __construct(PchelowodRepository $pchelowods, Flusher $flusher)
    {
        $this->pchelowods = $pchelowods;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $pchelowod = $this->pchelowods->get(new Id($command->id));

        $pchelowod->edit(
            new Name(
                $command->firstName,
                $command->lastName
            ),
            new Email($command->email)
        );

        $this->flusher->flush();
    }
}