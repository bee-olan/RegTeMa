<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Edit;

use App\Model\Adminka\Entity\OtecForRas\Rasa;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $title;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

   public static function fromRasa(Rasa $rasa): self
    {
       $command = new self($rasa->getId()->getValue());
       $command->name = $rasa->getName();
       $command->title = $rasa->getTitle();
       return $command;
    }
}
