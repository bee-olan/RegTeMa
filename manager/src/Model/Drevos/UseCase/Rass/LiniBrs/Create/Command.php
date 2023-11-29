<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\Create;

use App\Model\Drevos\Entity\Rass\Ras;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $rasa;
	
    /**
     * @Assert\NotBlank()
     */
    public $name;

	
	/**
     * @Assert\NotBlank()
     */
    public $sortLiniBr;

    public function __construct( string $rasa)
    {
        $this->rasa = $rasa;
    }

    public static function fromRas(Ras $rasa, int $maxSort): self
    {

        $command = new self($rasa->getId()->getValue());
        $command->sortLiniBr = $maxSort;
//        $command->name =  $rasa->getName();

        return $command;
    }
}
