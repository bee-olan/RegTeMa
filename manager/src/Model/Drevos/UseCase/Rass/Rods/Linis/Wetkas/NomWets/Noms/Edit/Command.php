<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Noms\Edit;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Noms\Nom;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $nomwet;
	
    /**
     * @Assert\NotBlank()
     */
    public $id;


    /**
     * @Assert\NotBlank()
     */
    public $nom;

    /**
     * @Assert\NotBlank()
     */
    public $god;

    /**
     * @Assert\NotBlank()
     */
    public $nameOt;

    public function __construct(string $nomwet, string $id)
    {
        $this->nomwet = $nomwet;
        $this->id = $id;
    }

    public static function fromNomWet(NomWet $nomwet, Nom $nom): self
    {
        $command = new self($nomwet->getId()->getValue(), $nom->getId()->getValue());
        $command->nom = $nom->getNom();
        $command->god = $nom->getGod();

        $command->nameOt = $nom->getNameOt();
        return $command;
    }
}
