<?php

declare(strict_types=1);

namespace App\Model\Matkis\UseCase\U4astniks\U4astnik\Reinstate;

use App\Model\Flusher;
use App\Model\Matkis\Entity\U4astniks\U4astnik\Id;
use App\Model\Matkis\Entity\U4astniks\U4astnik\U4astnikRepository;

class Handler
{
    private $u4astniks;
    private $flusher;

    public function __construct(U4astnikRepository $u4astniks, Flusher $flusher)
    {
        $this->u4astniks = $u4astniks;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $u4astnik = $this->u4astniks->get(new Id($command->id));

        $u4astnik->reinstate();

        $this->flusher->flush();
    }
}
