<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Rasas\Linias\Create;

use App\Model\Adminka\Entity\Rasas\Rasa;
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
    public $nameStar;
	
	 /**
     * @Assert\NotBlank()
     */
    public $title;
	
	/**
     * @Assert\NotBlank()
     */
    public $sortLinia;

//    /**
//     * @Assert\NotBlank()
//     */
//    public $vetka;

    public function __construct( string $rasa)
    {
        $this->rasa = $rasa;
    }

    public static function fromRasa(Rasa $rasa, int $maxSort): self
    {

        $command = new self($rasa->getId()->getValue());
        $command->sortLinia = $maxSort;
        $command->name =  $rasa->getName();
        $command->title = $rasa->getName();
//        $command->name = "л-".$maxSort;
//        $command->title = $rasa->getName()."_".$command->name;
//        dd($rasa->getName());
        return $command;
    }
}
