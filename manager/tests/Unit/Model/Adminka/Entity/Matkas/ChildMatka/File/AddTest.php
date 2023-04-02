<?php


namespace App\Tests\Unit\Model\Adminka\Entity\Matkas\ChildMatka\File;


//use App\Model\Work\Entity\PlemMatkas\ChildMatka\File\File;
//use App\Model\Work\Entity\PlemMatkas\ChildMatka\File\Id;
//use App\Model\Work\Entity\PlemMatkas\ChildMatka\File\Info;


use App\Model\Adminka\Entity\Matkas\ChildMatka\File\File;
use App\Model\Adminka\Entity\Matkas\ChildMatka\File\Id;
use App\Model\Adminka\Entity\Matkas\ChildMatka\File\Info;
use App\Tests\Builder\Adminka\Matkas\KategoriaBuilder;
use App\Tests\Builder\Adminka\Matkas\MestoNomerBuilder;
use App\Tests\Builder\Adminka\Matkas\PersonaBuilder;
use App\Tests\Builder\Adminka\Matkas\Rasas\LiniaBuilder;
use App\Tests\Builder\Adminka\Matkas\Rasas\NomerBuilder;
use App\Tests\Builder\Adminka\Matkas\Rasas\RasaBuilder;
use App\Tests\Builder\Adminka\Matkas\SparingBuilder;
use App\Tests\Builder\Adminka\Uchasties\GroupBuilder;
use App\Tests\Builder\Adminka\Uchasties\UchastieBuilder;
use App\Tests\Builder\Adminka\Matkas\PlemMatkaBuilder;
use App\Tests\Builder\Adminka\Matkas\ChildMatkaBuilder;
use PHPUnit\Framework\TestCase;

class AddTest extends TestCase
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

        $childmatka->addFile(
            $id = Id::next(),
            $uchastie,
            $date = new \DateTimeImmutable('+1 day'),
            $info = new Info('path', 'name.jpg', 356)
        );

        self::assertCount(1, $files = $childmatka->getFiles());
        self::assertInstanceOf(File::class, $file = end($files));

        self::assertEquals($id, $file->getId());
        self::assertEquals($date, $file->getDate());
        self::assertEquals($uchastie, $file->getUchastie());
        self::assertEquals($info, $file->getInfo());
    }
}