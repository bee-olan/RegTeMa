<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Edit;


use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Wetka;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $wetka;
	
    /**
     * @Assert\NotBlank()
     */
    public $id;


    /**
     * @Assert\NotBlank()
     */
    public $nomW;

    /**
     * @Assert\NotBlank()
     */
    public $godW;

    public function __construct(string $wetka, string $id)
    {
        $this->wetka = $wetka;
        $this->id = $id;
    }

    public static function fromWetka(Wetka $wetka, NomWet $nomwet): self
    {
        $command = new self($wetka->getId()->getValue(), $nomwet->getId()->getValue());
        $command->nomW = $nomwet->getNomW();
        $command->godW = $nomwet->getGodW();
        $command->titW = $nomwet->getTitW();
        return $command;
    }
}
