<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\IzChildPlems\CreateChildLinia;

use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\Model\Adminka\Entity\Rasas\Rasa;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $plemmatkaId;

    /**
     * @Assert\NotBlank()
     */
    public $parent;
	
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

    public function __construct(int $parent)
    {
        // $this->plemmatkaId = $plemmatkaId;
        $this->parent = $parent;
    }

}
