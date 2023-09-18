<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\Create;


use App\Model\Drevos\Entity\Rass\Rods\Linis\Lini;
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

	
	/**
     * @Assert\NotBlank()
     */
    public $sortWetka;


    public function __construct( string $linia)
    {
        $this->linia = $linia;
    }

    public static function fromLinia(Lini $linia, int $maxSort): self
    {

        $command = new self($linia->getId()->getValue());
        $command->sortWetka = $maxSort;


        return $command;
    }
}
