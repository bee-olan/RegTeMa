<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Remove;

use App\Model\Flusher;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrevRepository;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\Id;
//use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrev;

class Handler
{
    private $childmatkas;
    private $flusher;

    public function __construct(ChildDrevRepository $childmatkas, Flusher $flusher)
    {
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $childmatka = $this->childmatkas->get(new Id($command->id));

        $this->childmatkas->remove($childmatka);

        $this->flusher->flush();
    }
}