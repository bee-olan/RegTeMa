<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Edit;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\MatTrut;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Nom;
//use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $mattrut;
	
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



    public function __construct(string $mattrut, string $id)
    {
        $this->mattrut = $mattrut;
        $this->id = $id;
    }

    public static function fromNomWet(MatTrut $mattrut, Nom $nom): self
    {
        $command = new self($mattrut->getId()->getValue(), $nom->getId()->getValue());
        $command->nom = $nom->getNom();
        $command->god = $nom->getGod();

        return $command;
    }
}
