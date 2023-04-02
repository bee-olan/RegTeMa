<?php


namespace App\Tests\Builder\Adminka\Matkas\Rasas;;


use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Nomer;

class NomerBuilder
{
    private $name;
    private $nameStar;
    private $title;
    private $sortNomer;


//string $name,
//string $nameStar,
//string $title,
//int $sortNomer

    public function __construct()
    {
        $this->name = 'н-1';
        $this->nameStar = '1 запись о номере для Ср_л-1';
        $this->title= 'Ср_л-1_н-1';
        $this->sortNomer = 1;
    }

    public function build(Linia $linia): Nomer
    {
        return new Nomer(
            $linia,
            Id::next(),
            $this->name,
            $this->nameStar,
            $this->title,
            $this->sortNomer
        );
    }
}