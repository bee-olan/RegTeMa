<?php

declare(strict_types=1);

namespace App\Model\Matkis\UseCase\U4astniks\U4astnik\Edit;

use App\Model\Flusher;
use App\Model\Matkis\Entity\U4astniks\U4astnik\Email;
use App\Model\Matkis\Entity\U4astniks\U4astnik\Id;
use App\Model\Matkis\Entity\U4astniks\U4astnik\U4astnikRepository;
use App\Model\Matkis\Entity\U4astniks\U4astnik\Name;

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

        $u4astnik->edit(
            new Name(
                $command->firstName,
                $command->lastName
            ),
            new Email($command->email)
        );

        $this->flusher->flush();
    }
}