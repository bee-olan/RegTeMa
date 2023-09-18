<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Create;

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
    public $nameMatkov;

    /**
     * @Assert\NotBlank()
     */
    public $kodMatkov;

    /**
     * @Assert\NotBlank()
     */
    public $strana;


	/**
     * @Assert\NotBlank()
     */
    public $sortRodo;


    public function __construct( string $rasa)
    {
        $this->rasa = $rasa;
    }

    public static function fromRasa(Ras $rasa, int $maxSort): self
    {

        $command = new self($rasa->getId()->getValue());
        $command->sortRodo = $maxSort;

        return $command;
    }
}
