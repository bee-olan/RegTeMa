<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\UchasDrev\Add;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\DrevMatkaRepository;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\Id ;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\SezonDrev\Id as SezonDrevId;
use App\Model\Flusher;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;



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
        $plemmatka = $this->plemmatkas->get(new Id($command->plemmatka));

//        $uchastie = $this->uchasties->get(new UchastieId($plemmatka->getUchastieId()));


        $uchastie = $this->uchasties->get(new UchastieId($command->uchastie));


        $sezondrevs = array_map(static function (string $id): SezonDrevId {
            return new SezonDrevId($id);
        }, $command->sezondrevs);

//dd($roles);
        $plemmatka->addUchastie($uchastie, $sezondrevs);

        $this->flusher->flush();
    }
}

