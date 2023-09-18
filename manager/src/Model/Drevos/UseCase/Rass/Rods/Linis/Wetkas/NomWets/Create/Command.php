<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Create;

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
    public $nomW;

    /**
     * @Assert\NotBlank()
     */
    public $god;

   /**
    * @Assert\NotBlank()
    */
   public $titW;
	
	/**
     * @Assert\NotBlank()
     */
    public $sortNomWet;
 

    public function __construct( string $wetka)
    {
        $this->wetka = $wetka;
    }

    public static function fromWetka(Wetka $wetka, int $maxSort): self
    {

        $command = new self($wetka->getId()->getValue());
        $command->sortNomWet = $maxSort;
        $command->titW = "-";

        return $command;
    }
}
