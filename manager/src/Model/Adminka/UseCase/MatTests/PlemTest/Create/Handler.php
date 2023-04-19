<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\MatTests\PlemTest\Create;

use App\Model\Adminka\Entity\MatTests\PlemTest\PlemTest;
use App\Model\Adminka\Entity\MatTests\PlemTest\Id;
use App\Model\Adminka\Entity\MatTests\PlemTest\PlemTestRepository;
use App\Model\Flusher;



class Handler
{
    private $plemtests;
    private $flusher;

    public function __construct(PlemTestRepository $plemtests,
                             Flusher $flusher)
    {
        $this->plemtests = $plemtests;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $id = new Id($command->id);

        $plemtest = new PlemTest(
            $id,
            $command->name,
            $command->title,
            $command->goda_vixod,
            $command->star_linia,
            $command->star_nomer
        );

        $this->plemtests->add($plemtest);

        $this->flusher->flush();
    }
}
