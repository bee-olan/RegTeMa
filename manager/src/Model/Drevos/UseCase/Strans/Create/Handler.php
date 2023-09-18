<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Strans\Create;


use App\Model\Drevos\Entity\Strans\Stran;
use App\Model\Drevos\Entity\Strans\Id;
use App\Model\Drevos\Entity\Strans\StranRepository;
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
        $strana = new Stran(
            Id::next(),
            $command->name,
			$command->nomer
        );

        $this->stranas->add($strana);

        $this->flusher->flush();
    }
}
