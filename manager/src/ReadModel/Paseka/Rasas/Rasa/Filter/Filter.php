<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Rasas\Rasa\Filter;

//use App\Model\Work\Entity\Members\Member\Status;

class Filter
{
    public $pchelowod;
    public $name;
    public $psewdo;
    // public $status = Status::ACTIVE;

    private function __construct(?string $pchelowod)
    {
        $this->pchelowod = $pchelowod;
    }

    public static function all(): self
    {
        return new self(null);
    }

    public static function forPchelowod(string $id): self
    {
        return new self($id);
    }
}
