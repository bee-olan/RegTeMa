<?php


namespace App\Tests\Builder\Adminka\Matkas\Rasas;


use App\Model\Adminka\Entity\Rasas\Id;
use App\Model\Adminka\Entity\Rasas\Rasa;

class RasaBuilder
{
    private $name;
    private $title;

    public function __construct()
    {
        $this->name = 'Ср';
        $this->title= 'Среднерусская';
    }

    public function build(): Rasa
    {
        return new Rasa(
            Id::next(),
            $this->name,
            $this->title
        );
    }
}