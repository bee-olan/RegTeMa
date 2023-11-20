<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\Edit;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\DrevMatka;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $title;



    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromDrevMatka(DrevMatka $plemmatka): self
    {
        $command = new self($plemmatka->getId()->getValue());
        $command->title = $plemmatka->getTitle();

        return $command;
    }
}
