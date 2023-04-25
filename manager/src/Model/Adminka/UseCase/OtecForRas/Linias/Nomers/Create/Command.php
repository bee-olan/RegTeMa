<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Linias\Nomers\Create;

use App\Model\Adminka\Entity\OtecForRas\Linias\Linia;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $linia;

	
//    /**
//     * @Assert\NotBlank()
//     */
//    public $name;
	
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
//        $command->name = "";
        $command->title = $linia->getTitle();
//dd($command);
        return $command;
    }
}
