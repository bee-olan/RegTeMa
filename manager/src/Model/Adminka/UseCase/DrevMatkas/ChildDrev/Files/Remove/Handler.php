<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Files\Remove;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Flusher;

use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrevRepository;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\Id;

use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\File\Id as FileId;

class Handler
{

    private $uchasties;
    private $childmatkas;
    private $flusher;

    public function __construct(UchastieRepository $uchasties, ChildDrevRepository $childmatkas, Flusher $flusher)
    {
        $this->uchasties = $uchasties;
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $actor = $this->uchasties->get(new UchastieId($command->actor));
        $childmatka = $this->childmatkas->get(new Id($command->id));

        $childmatka->removeFile( $actor, new \DateTimeImmutable(), FileId::next());

        $this->flusher->flush();
    }
}


