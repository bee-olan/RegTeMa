<?php


namespace App\Tests\Builder\Adminka\Matkas;


use App\Model\Adminka\Entity\Uchasties\Personas\Id;
use App\Model\Adminka\Entity\Uchasties\Personas\Persona;

class PersonaBuilder
{
    private $nomer;

    public function __construct()
    {
        $this->nomer = 33;
    }

    public function build(): Persona
    {
        return new Persona(
            Id::next(),
            $this->nomer
        );
    }
}