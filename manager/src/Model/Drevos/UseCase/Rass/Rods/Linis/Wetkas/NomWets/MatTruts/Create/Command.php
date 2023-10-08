<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Create;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $nomwet;

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
	
	/**
     * @Assert\NotBlank()
     */
    public $sortTrut;

//    /**
//     * @Assert\NotBlank()
//     */
//    public $tit;

//    /**
//     * @Assert\NotBlank()
//     */
//    public $zakaz;


    public function __construct( string $nomwet)
    {
        $this->nomwet = $nomwet;
    }

    public static function fromNomWet(NomWet $nomwet, int $maxSort): self
    {

        $command = new self($nomwet->getId()->getValue());
        $command->sortTrut = $maxSort;

        return $command;
    }
}
