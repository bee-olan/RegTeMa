<?php

namespace App\Tests\Builder\Adminka\Matkas;

namespace App\Tests\Unit\Model\Adminka\Entity\Matkas\ChildMatka;


use App\Model\Adminka\Entity\Matkas\ChildMatka\Status;
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

class ChangeStatusTest extends TestCase
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
            ->build( $plemmatka,  $uchastie,  $sparing);

        $childmatka->changeStatus($status = new Status(Status::REJECTED), $date = new \DateTimeImmutable());

        self::assertEquals($status, $childmatka->getStatus());


        self::assertEquals($date, $childmatka->getStartDate());
        self::assertNull($childmatka->getEndDate());
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
            ->build( $plemmatka,  $uchastie,  $sparing);

        $childmatka->changeStatus($status = new Status(Status::REJECTED ), $date = new \DateTimeImmutable());

        $this->expectExceptionMessage('Статус уже тот же.');
        $childmatka->changeStatus($status, $date);
    }


    public function testStartDate(): void
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
            ->build( $plemmatka,  $uchastie,  $sparing);

        $childmatka->changeStatus(
            new Status(Status::WORKING),
            $date = new \DateTimeImmutable('+1 day')
        );

        self::assertEquals($date, $childmatka->getStartDate());
        self::assertNull($childmatka->getEndDate());
    }

    public function testEndDateWithStartDate(): void
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
            ->build( $plemmatka,  $uchastie,  $sparing);

        $childmatka->changeStatus(
            new Status(Status::WORKING),
            $startDate = new \DateTimeImmutable('+1 day')
        );

        $childmatka->changeStatus(
            new Status(Status::DONE),
            $endDate = new \DateTimeImmutable('+1 day')
        );

        self::assertEquals($startDate, $childmatka->getStartDate());
        self::assertEquals($endDate, $childmatka->getEndDate());
    }

    public function testEndDateWithoutStartDate(): void
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
            ->build( $plemmatka,  $uchastie,  $sparing);

        $childmatka->changeStatus(
            new Status(Status::DONE),
            $endDate = new \DateTimeImmutable('+1 day')
        );

        self::assertEquals($endDate, $childmatka->getStartDate());
        self::assertEquals($endDate, $childmatka->getEndDate());
    }

    public function testEndDateReset(): void
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
            ->build( $plemmatka,  $uchastie,  $sparing);

        $childmatka->changeStatus(
            new Status(Status::DONE),
            $endDate = new \DateTimeImmutable('+1 day')
        );

        $childmatka->changeStatus(
            new Status(Status::WORKING),
            new \DateTimeImmutable('+2 days')
        );

        self::assertEquals($endDate, $childmatka->getStartDate());
        self::assertNull($childmatka->getEndDate());
    }
}