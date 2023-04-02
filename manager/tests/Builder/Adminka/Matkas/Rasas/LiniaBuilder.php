<?php


namespace App\Tests\Builder\Adminka\Matkas\Rasas;


use App\Model\Adminka\Entity\Rasas\Linias\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\Model\Adminka\Entity\Rasas\Rasa;

class LiniaBuilder
{
    private $name;
    private $nameStar;
    private $title;
    private $sortLinia;


//string $name,
//string $nameStar,
//string $title,
//int $sortNomer

    public function __construct()
    {

        $this->name = 'л-1';
        $this->nameStar = '1 запись о линии для Ср_л-1';
        $this->title= 'Ср_л-1';
        $this->sortNomer = 1;
    }

    public function build(Rasa $rasa): Linia
    {
        return new Linia(
            $rasa,
            Id::next(),
            $this->name,
            $this->nameStar,
            $this->title,
            $this->sortNomer
        );
    }
}