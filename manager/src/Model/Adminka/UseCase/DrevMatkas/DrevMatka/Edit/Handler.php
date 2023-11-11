<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\Edit;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatkaRepository;
use App\Model\Adminka\Entity\DrevMatkas\Id;
use App\Model\Flusher;



class Handler
{
    private $plemmatkas;
    private $flusher;

    public function __construct(DrevMatkaRepository $plemmatkas, Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
       // dd($command);
       // $sparing = $this->sparings->get(new SparingId($command->sparing));
        $plemmatka = $this->plemmatkas->get(new Id($command->id));

        $plemmatka->edit(
            $command->title
        );

        $this->flusher->flush();
    }
}
