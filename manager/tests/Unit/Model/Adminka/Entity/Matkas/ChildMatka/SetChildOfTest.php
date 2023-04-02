<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Adminka\Entity\Matkas\ChildMatka;


use App\Tests\Builder\Adminka\Matkas\ChildMatkaBuilder;
use App\Tests\Builder\Adminka\Matkas\KategoriaBuilder;
use App\Tests\Builder\Adminka\Matkas\MestoNomerBuilder;
use App\Tests\Builder\Adminka\Matkas\PersonaBuilder;
use App\Tests\Builder\Adminka\Matkas\PlemMatkaBuilder;
use App\Tests\Builder\Adminka\Matkas\Rasas\LiniaBuilder;
use App\Tests\Builder\Adminka\Matkas\Rasas\NomerBuilder;
use App\Tests\Builder\Adminka\Matkas\Rasas\RasaBuilder;
use App\Tests\Builder\Adminka\Matkas\SparingBuilder;
use App\Tests\Builder\Adminka\Uchasties\GroupBuilder;
use App\Tests\Builder\Adminka\Uchasties\UchastieBuilder;

use PHPUnit\Framework\TestCase;

class SetChildOfTest  extends TestCase
{
    //успешный тест
    public function testSuccess(): void
    {
        $group = (new GroupBuilder())->build();
        $uchastie = (new UchastieBuilder())->build($group);
        $mesto = (new MestoNomerBuilder())->build();
        $sparing =  (new SparingBuilder())->build();
        $rasa  = (new RasaBuilder())->build();
        $linia  = (new LiniaBuilder())->build($rasa);
        $nomer  = (new NomerBuilder())->build($linia);
        $persona = (new  PersonaBuilder())->build();
        $kategoria  = (new KategoriaBuilder())->build();
        $plemmatka = (new PlemMatkaBuilder())->build( $mesto,  $nomer,   $persona,  $kategoria);

        $childmatka = (new ChildMatkaBuilder())->build( $plemmatka,  $uchastie,  $sparing);
        $parent = (new ChildMatkaBuilder())->build( $plemmatka,  $uchastie,  $sparing);

        $childmatka->setChildOf($parent);

        self::assertEquals($parent, $childmatka->getParent());

    }
//тест Пустой
    public function testEmpty(): void
    {
        $group = (new GroupBuilder())->build();
        $uchastie = (new UchastieBuilder())->build($group);
        $mesto = (new MestoNomerBuilder())->build();
        $sparing =  (new SparingBuilder())->build();
        $rasa  = (new RasaBuilder())->build();
        $linia  = (new LiniaBuilder())->build($rasa);
        $nomer  = (new NomerBuilder())->build($linia);
        $persona = (new  PersonaBuilder())->build();
        $kategoria  = (new KategoriaBuilder())->build();
        $plemmatka = (new PlemMatkaBuilder())->build( $mesto,  $nomer,   $persona,  $kategoria);
        $childmatka = (new ChildMatkaBuilder())->build( $plemmatka,  $uchastie,  $sparing);


        $childmatka->setChildOf(null);

        self::assertNull($childmatka->getParent());
    }
//проверка себя
    public function testSelf(): void
    {
        $group = (new GroupBuilder())->build();
        $uchastie = (new UchastieBuilder())->build($group);
        $mesto = (new MestoNomerBuilder())->build();
        $sparing =  (new SparingBuilder())->build();
        $rasa  = (new RasaBuilder())->build();
        $linia  = (new LiniaBuilder())->build($rasa);
        $nomer  = (new NomerBuilder())->build($linia);
        $persona = (new  PersonaBuilder())->build();
        $kategoria  = (new KategoriaBuilder())->build();
        $plemmatka = (new PlemMatkaBuilder())->build( $mesto,  $nomer,   $persona,  $kategoria);
        $childmatka = (new ChildMatkaBuilder())->build( $plemmatka,  $uchastie,  $sparing);


        $this->expectExceptionMessage('Цикломатические дети.');
        $childmatka->setChildOf($childmatka);
    }

//// тест на цикличность

    public function testCycle(): void
    {
        $group = (new GroupBuilder())->build();
        $uchastie = (new UchastieBuilder())->build($group);
        $mesto = (new MestoNomerBuilder())->build();
        $sparing =  (new SparingBuilder())->build();
        $rasa  = (new RasaBuilder())->build();
        $linia  = (new LiniaBuilder())->build($rasa);
        $nomer  = (new NomerBuilder())->build($linia);
        $persona = (new  PersonaBuilder())->build();
        $kategoria  = (new KategoriaBuilder())->build();
        $plemmatka = (new PlemMatkaBuilder())->build( $mesto,  $nomer,   $persona,  $kategoria);
        $childmatka = (new ChildMatkaBuilder())->build( $plemmatka,  $uchastie,  $sparing);


        $child1 = (new ChildMatkaBuilder())->build( $plemmatka,  $uchastie,  $sparing);
        $child2 = (new ChildMatkaBuilder())->build( $plemmatka,  $uchastie,  $sparing);

        $child1->setChildOf($childmatka);
        $child2->setChildOf($child1);

        $this->expectExceptionMessage('Цикломатические дети.');
        $childmatka->setChildOf($child2);
    }
}