<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Linias\Create;

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
    public $name;

	 /**
     * @Assert\NotBlank()
     */
    public $title;


    public function __construct( string $rasa)
    {
        $this->rasa = $rasa;
    }

    public static function fromRasa(Rasa $rasa): self
    {

        $command = new self($rasa->getId()->getValue());
//        $command->name =  $rasa->getName();
//        $command->title = $rasa->getName();
        return $command;
    }
}
