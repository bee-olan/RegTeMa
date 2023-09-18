<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Edit;


use App\Model\Drevos\Entity\Rass\Ras;
use App\Model\Drevos\Entity\Rass\Rods\Rod;
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
    public $id;

    /**
     * @Assert\NotBlank()
     */
    public $nameMatkov;

    /**
     * @Assert\NotBlank()
     */
    public $kodMatkov;


    public function __construct(string $rasa, string $id)
    {
        $this->rasa = $rasa;
        $this->id = $id;
    }

    public static function fromRodo(Ras $rasa, Rod $rodo): self
    {
        $command = new self($rasa->getId()->getValue(), $rodo->getId()->getValue());
        $command->nameMatkov = $rodo->getNameMatkov();
        $command->kodMatkov = $rodo->getKodMatkov();

        return $command;
    }
}
