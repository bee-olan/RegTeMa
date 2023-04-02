<?php


namespace App\Tests\Builder\Adminka\Matkas;


use App\Model\Adminka\Entity\Matkas\Kategoria\Kategoria;
use App\Model\Adminka\Entity\Matkas\PlemMatka\Id;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Nomer;
use App\Model\Adminka\Entity\Uchasties\Personas\Persona;
use App\Model\Mesto\Entity\InfaMesto\MestoNomer;

class PlemMatkaBuilder
{
    private $name;
    private $sort;
    private $title;
    private $godaVixod;
    private $mesto;
    private $nomer;
    private $persona;
    private $kategoria;
//string $title,
//int $godaVixod,
//MestoNomer  $mesto,
//Nomer $nomer,
//Persona  $persona,
//Kategoria $kategoria
    public function __construct()
    {
        $this->name = 'PlemMatka';
        $this->sort = 1;
        $this->title = 'title_PlemMatka';
        $this->godaVixod = 2020;
    }

    public function build(MestoNomer $mesto, Nomer $nomer, Persona  $persona, Kategoria $kategoria): PlemMatka
    {
        return new PlemMatka(
            Id::next(),
            $this->name,
            $this->sort,
            $this->title,
            $this->godaVixod,
            $mesto,
            $nomer,
            $persona,
            $kategoria
        );
    }
}