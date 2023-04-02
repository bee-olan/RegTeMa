<?php


namespace App\Tests\Builder\Adminka\Matkas;


use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatka;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Id;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Status;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Type;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;

class ChildMatkaBuilder
{
    private $id;
    private $date;
    private $type;
    private $priority;
    private $name;
    private $content;
    private $godaVixod;
    private $status;
    private  $kolChild;
    private $sezonPlem;
    private $sezonChild;

    public function __construct()
    {
        $this->id = new Id(1);
        $this->date = new \DateTimeImmutable();
        $this->type = new Type(Type::TFBK);
        $this->priority = 1;
        $this->name = 'Task';
        $this->content = 'Content';
        $this->kolChild = 2;
        $this->godaVixod = 2020;
        $this->sezonPlem = '2020-2021';
        $this->sezonChild = '2022-2023';
        $this->status = new Status(Status::NEW);

    }

    public function withType(Type $type): self
    {
        $clone = clone $this;
        $clone->type = $type;
        return $clone;
    }

    public function build(PlemMatka $plemmatka, Uchastie $author): ChildMatka
    {
        return new ChildMatka(
            $this->id,
            $plemmatka,
            $author,
            $this->date,
            $this->type,
            $this->priority,
            $this->name,
            $this->content,
            $this->kolChild,
            $this->godaVixod,
            $this->sezonPlem,
            $this->sezonChild
//            $this->status

        );
    }
}