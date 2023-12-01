<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\NomerBrs\Remove;

use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\VetBrRepository;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\Id;
use App\Model\Flusher;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr\Id as NomerBrId;


class Handler
{
    private $vetkas;
    private $flusher;

    public function __construct(VetBrRepository $vetkas, Flusher $flusher)
    {
        $this->vetkas = $vetkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $vetka = $this->vetkas->get(new Id($command->vetka));

        $vetka->removeNomBr(new NomerBrId($command->id));

        $this->flusher->flush();
    }
}

