<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Strans\Remove;

use App\Model\Drevos\Entity\Strans\StranRepository;
use App\Model\Drevos\Entity\Strans\Id;
use App\Model\Flusher;



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
        $strana = $this->stranas->get(new Id($command->id));

        $this->stranas->remove($strana);

        $this->flusher->flush();
    }
}
