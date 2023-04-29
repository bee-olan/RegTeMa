<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Rasas\Linias\CreateNomLin;

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

    public static function fromRasa(Rasa $rasa, Linia $linia, int $maxSort, string $nomNameStar): self
    {
//dd($linia);
        $command = new self($rasa->getId()->getValue());

        $command->sortLinia = $maxSort;
//        dd($nomNameStar);
        $command->name = $linia->getName();
//        $title = explode("_",$linia->getTitle() );
        $command->title =  $linia->getTitle();
//        dd($linia->getTitle());
//        $nomNameStar = explode("-",$nomNameStar );
        $command->nameStar = $nomNameStar;
//        $command->nameStar =  $linia->getNameStar()."-".$nomNameStar[0];
//dd($command->title );
//        $command = new self($rasa->getId()->getValue());
//        $command->sortLinia = $maxSort;
//        $command->name = "л-".$maxSort;
//        $title = explode("_",$linia->getTitle() );
//        $command->title =  $title[0]."_".$command->name;
//        $nomNameStar = explode("-",$nomNameStar );
//       $command->nameStar =  $linia->getNameStar()."-".$nomNameStar[0];

//       dd($command);
        return $command;
    }
}
