<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\Edit;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Lini;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Wetka;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $linia;

    /**
     * @Assert\NotBlank()
     */
    public $nameW;

//    /**
//     * @Assert\NotBlank()
//     */
//    public $sortWetka;


    public function __construct(string $linia, string $id)
    {
        $this->linia = $linia;
        $this->id = $id;
    }

    public static function fromLinia( Lini $linia, Wetka $wetka): self
    {
        $command = new self($linia->getId()->getValue(), $wetka->getId()->getValue());
        $command->nameW = $wetka->getNameW();

        return $command;
    }
}
