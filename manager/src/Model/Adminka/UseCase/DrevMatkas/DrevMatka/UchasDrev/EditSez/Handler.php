<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\UchasDrev\EditSez;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatkaRepository;
use App\Model\Adminka\Entity\DrevMatkas\Id;
use App\Model\Flusher;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Adminka\Entity\DrevMatkas\SezonDrev\Id as SezonDrevId;


class Handler
{
    private $plemmatkas;
    private $uchasties;
    private $flusher;

    public function __construct(
        DrevMatkaRepository $plemmatkas,
        UchastieRepository $uchasties,
        Flusher $flusher
    )
    {
        $this->plemmatkas = $plemmatkas;
        $this->uchasties = $uchasties;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $plemmatka = $this->plemmatkas->get(new Id($command->plemmatka)) ;
        $uchastie = $this->uchasties->get(new UchastieId($command->uchastie));


        $sezondrevs = array_map(static function (string $id): SezonDrevId {
            return new SezonDrevId($id);
        }, $command->sezondrevs);


        $plemmatka->editSezonUchastie($uchastie->getId(), $sezondrevs);

        $this->flusher->flush();
    }
}

