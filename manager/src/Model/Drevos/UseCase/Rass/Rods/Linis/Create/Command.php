<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Create;


use App\Model\Drevos\Entity\Rass\Rods\Rod;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $rodo;
	
    /**
     * @Assert\NotBlank()
     */
    public $name;
	

	
	/**
     * @Assert\NotBlank()
     */
    public $sortLini;


    public function __construct( string $rodo)
    {
        $this->rodo = $rodo;
    }

    public static function fromRodo(Rod $rodo, int $maxSort): self
    {

        $command = new self($rodo->getId()->getValue());
        $command->sortLini = $maxSort;
$command->name = "-";

        return $command;
    }
}
