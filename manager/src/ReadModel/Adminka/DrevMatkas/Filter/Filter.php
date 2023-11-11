<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\DrevMatkas\Filter;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Status;

class Filter
{
    public $name;
//    public $persona_id;
    public $status = Status::ACTIVE;
    public $uchastie;


    private function __construct(?string $uchastie)
    {
        $this->uchastie = $uchastie;
    }

    public static function allPagin(): self
    {
        return new self(null);
    }

    public static function forUchastie(string $id): self
    {
        return new self($id);
    }
}