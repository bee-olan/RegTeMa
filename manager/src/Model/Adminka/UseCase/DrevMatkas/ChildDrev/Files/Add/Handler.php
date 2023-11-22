<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Files\Add;

use App\Model\Flusher;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrevRepository;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\Id;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\File\Id as FileId;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\File\Info;

use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;

//use App\Model\Adminka\Entity\Matkas\ChildMatka\File\Id as FileId;


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

        foreach ($command->files as $file) {
            $childmatka->addFile(
                $actor, new \DateTimeImmutable(),
                FileId::next(),
                new Info(
                    $file->path,
                    $file->name,
                    $file->size
                )
            );
        }

        $this->flusher->flush();
    }
}

