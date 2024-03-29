<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Rasas\Linias\Nomers\Create;

use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $linia;

	
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
    public $sortNomer;

    public function __construct(string $linia)
    {
        $this->linia = $linia;
    }
    public static function fromLinia(Linia $linia, int $maxSort): self
    {

        $command = new self($linia->getId()->getValue());
        $command->sortNomer = $maxSort;
        $command->name = "н-".$maxSort;
        $command->title = $linia->getTitle()."_".$command->name;

        return $command;
    }
}
