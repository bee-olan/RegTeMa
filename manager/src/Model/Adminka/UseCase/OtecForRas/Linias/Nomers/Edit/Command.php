<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Linias\Nomers\Edit;

use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Nomer;
use App\Model\Adminka\Entity\OtecForRas\Linias\Linia;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $linia;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $matkaLinia;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $matkaNomer;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $otecLinia;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $otecNomer;


    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $title;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $oblet;

    public function __construct(string $linia, string $id)
    {
        
        $this->linia = $linia;
        $this->id = $id;
    }

    public static function fromNomer(Linia $linia, Nomer $nomer): self
    {
        //dd($linia);
        $command = new self($linia->getId()->getValue(), $nomer->getId()->getValue());
        $command->name = $nomer->getName();
        $command->matkaLinia = $nomer->getMatka()->getLinia();
		$command->matkaNomer = $nomer->getMatka()->getNomer();
		$command->otecLinia = $nomer->getOtec()->getLinia();
        $command->otecNomer = $nomer->getOtec()->getNomer();
        $command->oblet = $nomer->getOblet();
		$command->title = $nomer->getTitle();
        return $command;
    }
}
