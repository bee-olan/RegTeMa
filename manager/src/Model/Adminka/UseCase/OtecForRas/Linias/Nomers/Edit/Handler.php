<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Linias\Nomers\Edit;

use App\Model\Flusher;
use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Id as NomerId;
use App\Model\Adminka\Entity\OtecForRas\Linias\Id;
use App\Model\Adminka\Entity\OtecForRas\Linias\LiniaRepository;

class Handler
{
    private $linias;
    private $flusher;

    public function __construct(LiniaRepository $linias, Flusher $flusher)
    {
        $this->linias = $linias;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $linia = $this->linias->get(new Id($command->linia));

        $linia->editNomer(new NomerId($command->id),
										$command->name, 
										$command->nameStar, 
										$command->title);

        $this->flusher->flush();
    }
}

