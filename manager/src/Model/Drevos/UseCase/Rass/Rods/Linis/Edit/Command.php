<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Edit;


use App\Model\Drevos\Entity\Rass\Rods\Linis\Lini;
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
    public $id;

    /**
     * @Assert\NotBlank()
     */
    public $name;

	


    public function __construct(string $rodo, string $id)
    {
        $this->rodo = $rodo;
        $this->id = $id;
    }

    public static function fromLinia(Rod $rodo, Lini $linia): self
    {
        $command = new self($rodo->getId()->getValue(), $linia->getId()->getValue());
        $command->name = $linia->getName();

        return $command;
    }
}
