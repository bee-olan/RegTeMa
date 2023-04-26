<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Linias\Edit;

use App\Model\Adminka\Entity\OtecForRas\Linias\Linia;
use App\Model\Adminka\Entity\OtecForRas\Rasa;
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

	
	 /**
     * @Assert\NotBlank()
     */
    public $title;

    public function __construct(string $rasa, string $id)
    {
        $this->rasa = $rasa;
        $this->id = $id;
    }

    public static function fromLinia(Rasa $rasa, Linia $linia): self
    {
        $command = new self($rasa->getId()->getValue(), $linia->getId()->getValue());
        $command->name = $linia->getName();
        $command->title = $linia->getTitle();
        return $command;
    }
}
