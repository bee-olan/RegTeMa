<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\DrevMatkas\ChildDrevs\Filter;

class Filter
{
    public $uchastie;
    public $author;
    public $plemmatka;
    public $text;
    public $goda_vixod;
    public $type;
    public $status;
    public $priority;
    public $executor;
    public $name;
    public $roots; /// верхний уровень без дочерних
    public $urowni;

    private function __construct(?string $plemmatka)
    {
        $this->plemmatka = $plemmatka;
    }

    public static function forDrevMatka(string $plemmatka): self
    {
        return new self($plemmatka);
    }

    public static function allChildMat(): self
    {
        return new self(null);
    }

    public static function all(): self
    {
        return new self(null);
    }

    public function forUchastie(string $uchastie): self
    {
        $clone = clone $this;
        $clone->uchastie = $uchastie;
        return $clone;
    }

    public function forAuthor(string $author): self
    {
        $clone = clone $this;
        $clone->author = $author;
        return $clone;
    }

    public function forExecutor(string $executor): self
    {
        $clone = clone $this;
        $clone->executor = $executor;
        return $clone;
    }
}
