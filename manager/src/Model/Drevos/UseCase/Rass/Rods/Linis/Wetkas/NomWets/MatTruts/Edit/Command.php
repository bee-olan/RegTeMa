<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Edit;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\MatTrut;
//use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Noms\Nom;
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


//    /**
//     * @Assert\NotBlank()
//     */
//    public $nom;
//
//    /**
//     * @Assert\NotBlank()
//     */
//    public $god;

    /**
     * @Assert\NotBlank()
     */
    public $nameOt;

    public function __construct(string $nomwet, string $id)
    {
        $this->nomwet = $nomwet;
        $this->id = $id;
    }

    public static function fromNomWet(NomWet $nomwet, MatTrut $mattrut): self
    {
        $command = new self($nomwet->getId()->getValue(), $mattrut->getId()->getValue());

        $command->nameOt = $mattrut->getNameOt();
        return $command;
    }
}
