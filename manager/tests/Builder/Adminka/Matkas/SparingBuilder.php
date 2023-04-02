<?php


namespace App\Tests\Builder\Adminka\Matkas;


use App\Model\Adminka\Entity\Matkas\Sparings\Id;
use App\Model\Adminka\Entity\Matkas\Sparings\Sparing;

class SparingBuilder
{
    private $name;

    public function __construct()
    {
        $this->name = 'ос';
        $this->title = 'островная';
    }

    public function build(): Sparing
    {
        return new Sparing(
            Id::next(),
            $this->name,
            $this->title
        );
    }
}