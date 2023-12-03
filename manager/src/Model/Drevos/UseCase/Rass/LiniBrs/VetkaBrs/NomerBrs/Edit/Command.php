<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\NomerBrs\Edit;

use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr\NomerBr;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\VetkaBr;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $vetka;


    /**
     * @Assert\NotBlank()
     */
    public $id;


    /**
     * @Assert\NotBlank()
     */
    public $nomBr;

    /**
     * @Assert\NotBlank()
     */
    public $god;

//    /**
//     * @Assert\NotBlank()
//     */
//    public $title;

//    /**
//     * @Assert\NotBlank()
//     */
//    public $sortNom;

    public function __construct(string $vetka, string $id)
    {
        
        $this->vetka = $vetka;
        $this->id = $id;
    }

    public static function fromNomer(VetkaBr $vetka, NomerBr $nomer): self
    {
        //dd($vetka);
        $command = new self($vetka->getId()->getValue(), $nomer->getId()->getValue());
        $command->nomBr = $nomer->getNomBr();
		$command->god = $nomer->getGod();
		$command->title =  $command->nomBr."-".$command->god;
        return $command;
    }
}
