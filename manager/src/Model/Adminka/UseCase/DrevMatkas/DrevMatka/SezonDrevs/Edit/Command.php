<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\SezonDrevs\Edit;


use App\Model\Adminka\Entity\DrevMatkas\DrevMatka;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\SezonDrev\SezonDrev;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $plemmatka;
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank()
     */
    public $name;

    public function __construct(string $plemmatka, string $id)
    {
        $this->plemmatka = $plemmatka;
        $this->id = $id;
    }

    public static function fromSezonDrev(DrevMatka $plemmatka, SezonDrev $sezonDrev): self
    {
        $command = new self($plemmatka->getId()->getValue(), $sezonDrev->getId()->getValue());
        $command->name = $sezonDrev->getName();
        return $command;
    }
}
