<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\MatTests\PlemTest\Filter;

use App\Model\Adminka\Entity\MatTests\PlemTest\Status;

class Filter
{
    public $name;
    public $status = Status::ACTIVE;
    public $god_vixod;

    public $uchastie;


    private function __construct(?string $uchastie)
    {
        $this->uchastie = $uchastie;
    }

    public static function all(): self
    {
        return new self(null);
    }

    public static function forUchastie(string $id): self
    {
        return new self($id);
    }
}