<?php

namespace App\Tests\Builder\Adminka\Matkas;

namespace App\Tests\Unit\Model\Adminka\Entity\Matkas\ChildMatka;


use App\Model\Adminka\Entity\Matkas\ChildMatka\Type;
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

class ChangeTypeTest extends TestCase
{
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
        $childmatka = (new ChildMatkaBuilder())
            ->withType(new Type(Type::TFBK))
            ->build( $plemmatka,  $uchastie,  $sparing);

        $childmatka->changeType($type = new Type(Type::IO));

        self::assertEquals($type, $childmatka->getType());
    }
    public function testAlready(): void
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
        $childmatka = (new ChildMatkaBuilder())
            ->withType($type = new Type(Type::TFBK))
            ->build( $plemmatka,  $uchastie,  $sparing);

        $this->expectExceptionMessage('Тип уже тот же самый.');
        $childmatka->changeType($type);
    }
}