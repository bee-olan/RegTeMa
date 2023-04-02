<?php

declare(strict_types=1);

namespace App\Tests\Builder\Adminka\Matkas;


use App\Model\Mesto\Entity\InfaMesto\Id;
use App\Model\Mesto\Entity\InfaMesto\MestoNomer;

class MestoNomerBuilder
{
    private $nomer;
    private $raionId;

    public function __construct()
    {
        $this->nomer = '3-61-1';
        $this->raionId = '11-22-33-44';
    }

    public function build(): MestoNomer
    {
        return new MestoNomer(
            Id::next(),
            $this->raionId,
            $this->nomer
        );
    }

}