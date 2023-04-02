<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Adminka\Entity\Matkas\ChildMatka;

use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatka;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Id;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Status;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Type;

//use App\Model\Adminka\Entity\Matkas\PlemMatka\Status;
use App\Tests\Builder\Adminka\Matkas\KategoriaBuilder;
use App\Tests\Builder\Adminka\Matkas\Rasas\LiniaBuilder;
use App\Tests\Builder\Adminka\Matkas\Rasas\NomerBuilder;
use App\Tests\Builder\Adminka\Matkas\PersonaBuilder;
use App\Tests\Builder\Adminka\Matkas\PlemMatkaBuilder;
use App\Tests\Builder\Adminka\Matkas\MestoNomerBuilder;
use App\Tests\Builder\Adminka\Matkas\Rasas\RasaBuilder;
use App\Tests\Builder\Adminka\Uchasties\GroupBuilder;
use App\Tests\Builder\Adminka\Uchasties\UchastieBuilder;
use PHPUnit\Framework\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $group = (new GroupBuilder())->build();
        $uchastie = (new UchastieBuilder())->build($group);
        $mesto = (new MestoNomerBuilder())->build();
//        $sparing =  (new SparingBuilder())->build();
        $rasa  = (new RasaBuilder())->build();
        $linia  = (new LiniaBuilder())->build($rasa);
        $nomer  = (new NomerBuilder())->build($linia);
        $persona = (new  PersonaBuilder())->build();
        $kategoria  = (new KategoriaBuilder())->build();


        $plemmatka = (new PlemMatkaBuilder())->build( $mesto,  $nomer,   $persona,  $kategoria);

        $childmatka = new ChildMatka(
            $id = new Id(1),
            $plemmatka,
            $uchastie,
            $date = new \DateTimeImmutable(),
            $type = new Type(Type::TFBK),
            $priority = 2,
            $name = 'Test ChildMatka',
            $content = 'Test Content',
            $kolChild = 2,
             $godaVixod = 2020,
            $sezonPlem = '2020-2021',
                 $sezonChild = '2022-2023'
//            $status = new Status(Status::NEW)
        );

        self::assertEquals($id, $childmatka->getId());
        self::assertEquals($plemmatka, $childmatka->getPlemMatka());
        self::assertEquals($uchastie, $childmatka->getAuthor());
        self::assertEquals($date, $childmatka->getDate());
        self::assertEquals($type, $childmatka->getType());
//        self::assertEquals($status, $childmatka->getStatus());
        self::assertEquals($priority, $childmatka->getPriority());
        self::assertEquals($name, $childmatka->getName());
        self::assertEquals($content, $childmatka->getContent());

        self::assertEquals($sezonPlem, $childmatka->getSezonPlem());
        self::assertEquals($sezonChild, $childmatka->getSezonChild());

        self::assertNull($childmatka->getParent());
        self::assertNull($childmatka->getPlanDate());
        self::assertNull($childmatka->getStartDate());
        self::assertNull($childmatka->getEndDate());

        self::assertTrue($childmatka->isNew());
    }
}