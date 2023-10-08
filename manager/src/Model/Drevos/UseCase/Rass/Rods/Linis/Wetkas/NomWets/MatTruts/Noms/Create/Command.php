<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Create;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\MatTrut;
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
    public $nom;

    /**
     * @Assert\NotBlank()
     */
    public $god;

	
	/**
     * @Assert\NotBlank()
     */
    public $sortNom;

    /**
     * @Assert\NotBlank()
     */
    public $tit;

    /**
     * @Assert\NotBlank()
     */
    public $zakaz;


    public function __construct( string $mattrut)
    {
        $this->mattrut = $mattrut;
    }

    public static function fromMatTrut(MatTrut $mattrut, int $maxSort): self
    {

        $command = new self($mattrut->getId()->getValue());
        $command->sortNom = $maxSort;
        $command->tit = "-";
        return $command;
    }
}
