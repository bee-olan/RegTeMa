<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Adminka\Entity\Matkas\ChildMatka\Executor;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use App\Tests\Builder\Adminka\Matkas\ChildMatkaBuilder;
use App\Tests\Builder\Adminka\Matkas\KategoriaBuilder;
use App\Tests\Builder\Adminka\Matkas\MestoNomerBuilder;
use App\Tests\Builder\Adminka\Matkas\PersonaBuilder;
use App\Tests\Builder\Adminka\Matkas\PlemMatkaBuilder;
use App\Tests\Builder\Adminka\Matkas\Rasas\LiniaBuilder;
use App\Tests\Builder\Adminka\Matkas\Rasas\NomerBuilder;
use App\Tests\Builder\Adminka\Matkas\Rasas\RasaBuilder;
//use App\Tests\Builder\Adminka\Matkas\SparingBuilder;
use App\Tests\Builder\Adminka\Uchasties\GroupBuilder;
use App\Tests\Builder\Adminka\Uchasties\UchastieBuilder;
use PHPUnit\Framework\TestCase;

// привязываем  исполнителя к задаче
class AssignTest extends TestCase
{
    public function testSuccess(): void
    {
        $group = (new GroupBuilder())->build();
        $uchastie = (new UchastieBuilder())->build($group);
        $mesto = (new MestoNomerBuilder())->build();

        $rasa  = (new RasaBuilder())->build();
        $linia  = (new LiniaBuilder())->build($rasa);
        $nomer  = (new NomerBuilder())->build($linia);
        $persona = (new  PersonaBuilder())->build();
        $kategoria  = (new KategoriaBuilder())->build();
        $plemmatka = (new PlemMatkaBuilder())->build( $mesto,  $nomer,   $persona,  $kategoria);
        $childmatka = (new ChildMatkaBuilder())
            ->build( $plemmatka,  $uchastie);

        $executor = (new UchastieBuilder())->build($group);

        self::assertFalse($childmatka->hasExecutor($executor->getId()));

        $childmatka->assignExecutor($executor);

        self::assertEquals([$executor], $childmatka->getExecutors());
        self::assertTrue($childmatka->hasExecutor($executor->getId()));

    }

    public function testAlready(): void
    {
        $group = (new GroupBuilder())->build();
        $uchastie = (new UchastieBuilder())->build($group);
        $mesto = (new MestoNomerBuilder())->build();

        $rasa  = (new RasaBuilder())->build();
        $linia  = (new LiniaBuilder())->build($rasa);
        $nomer  = (new NomerBuilder())->build($linia);
        $persona = (new  PersonaBuilder())->build();
        $kategoria  = (new KategoriaBuilder())->build();
        $plemmatka = (new PlemMatkaBuilder())->build( $mesto,  $nomer,   $persona,  $kategoria);
        $childmatka = (new ChildMatkaBuilder())
            ->build( $plemmatka,  $uchastie);

        $executor = (new UchastieBuilder())->build($group);

        $childmatka->assignExecutor($executor);
        $this->expectExceptionMessage('Исполнитель уже назначен.');

        $childmatka->assignExecutor($executor);
    }
}