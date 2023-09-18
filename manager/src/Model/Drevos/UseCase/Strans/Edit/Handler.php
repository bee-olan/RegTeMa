<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Strans\Edit;

use App\Model\Flusher;
use App\Model\Drevos\Entity\Strans\StranRepository;
use App\Model\Drevos\Entity\Strans\Id;


class Handler
{
    private $stranas;
    private $flusher;

    public function __construct(StranRepository $stranas, Flusher $flusher)
    {
        $this->stranas = $stranas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $sparing = $this->stranas->get(new Id($command->id));

        $sparing->edit($command->name, $command->nomer);

        $this->flusher->flush();
    }
}
