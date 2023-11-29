<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\Edit;

use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\Model\Adminka\Entity\Rasas\Rasa;
use App\Model\Drevos\Entity\Rass\LiniBr\LiniBr;
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
    public $id;

    /**
     * @Assert\NotBlank()
     */
    public $name;


    public function __construct(string $rasa, string $id)
    {
        $this->rasa = $rasa;
        $this->id = $id;
    }

    public static function fromLiniBr(Ras $rasa, LiniBr $linia): self
    {
        $command = new self($rasa->getId()->getValue(), $linia->getId()->getValue());
        $command->name = $linia->getName();
        return $command;
    }
}
