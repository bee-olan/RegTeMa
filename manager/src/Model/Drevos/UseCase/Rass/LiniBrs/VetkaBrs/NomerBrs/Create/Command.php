<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\NomerBrs\Create;


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
    public $nomBr;
	
	 /**
     * @Assert\NotBlank()
     */
    public $title;

    /**
     * @Assert\NotBlank()
     */
    public $sortNom;

    public function __construct(string $vetka)
    {
        $this->vetka = $vetka;
    }
    public static function fromVetBr(VetkaBr $vetka, int $maxSort): self
    {

        $command = new self($vetka->getId()->getValue());
        $command->sortNom = $maxSort;

//dd($command);
        return $command;
    }
}
