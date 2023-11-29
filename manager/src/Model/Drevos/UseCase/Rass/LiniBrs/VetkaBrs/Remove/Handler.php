<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\Remove;

use App\Model\Drevos\Entity\Rass\LiniBr\Id ;
use App\Model\Drevos\Entity\Rass\LiniBr\LiniBrRepository;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\Id as VetkaBrId;

use App\Model\Flusher;

class Handler
{
    private $linias;
    private $flusher;

    public function __construct(LiniBrRepository $linias, Flusher $flusher)
    {
        $this->linias = $linias;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $linia = $this->linias->get(new Id($command->linia));

        $linia->removeVetkaBr(new VetkaBrId($command->id));

        $this->flusher->flush();
    }
}

