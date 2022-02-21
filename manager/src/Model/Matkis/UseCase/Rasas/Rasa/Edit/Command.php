<?php

declare(strict_types=1);

namespace App\Model\Matkis\UseCase\Rasas\Rasa\Edit;

use App\Model\Matkis\Entity\Rasas\Rasa\Rasa;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank()
     */
    public $name;
    /**
     * @Assert\NotBlank()
     */
    public $sort;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromRasa(Rasa $rasa): self
    {
        $command = new self($rasa->getId()->getValue());
        $command->name = $rasa->getName();
        $command->sort = $rasa->getSort();
        return $command;
    }
}
