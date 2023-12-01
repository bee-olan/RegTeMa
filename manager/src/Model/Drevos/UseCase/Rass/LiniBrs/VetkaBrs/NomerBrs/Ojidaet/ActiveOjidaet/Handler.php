<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\NomerBrs\Ojidaet\ActiveOjidaet;

use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr\Id;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr\NomBrRepository;
use App\Model\Flusher;


class Handler
{
    private $nomers;
    private $flusher;

    public function __construct(NomBrRepository $nomers, Flusher $flusher)
    {
        $this->nomers = $nomers;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $nomer = $this->nomers->get(new Id($command->id));


        $nomer->activeOjidaet();

        $this->flusher->flush();
    }
}