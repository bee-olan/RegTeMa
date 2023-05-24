<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\IzChildPlems\CreateChildLinia;

use App\Model\Adminka\Entity\Rasas\Linias\Linia;
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

    /**
     * @Assert\NotBlank()
     */
    public $vetka;

    public function __construct( string $rasa)
    {
        $this->rasa = $rasa;
//        $this->linia = $linia;
    }

    public static function fromRasa(Rasa $rasa,
                                    Linia $linia,
                                    int $maxSort,
                                    string $nomNameStar,
                                    string $idNomer
                            ): self
    {

        $command = new self($rasa->getId()->getValue());
        $command->idNomer = $idNomer;

        $command->sortLinia = $maxSort;
        $command->name = $linia->getName();
        $command->title =  $linia->getTitle();

        $command->nameStar = $nomNameStar;

//        $title = explode("_",$linia->getTitle() );
//dd($command);
        return $command;
    }
}
