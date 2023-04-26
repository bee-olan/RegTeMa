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

    public function __construct(string $linia)
    {
        $this->linia = $linia;
    }

    public static function fromLinia(Linia $linia): self
    {

        $command = new self($linia->getId()->getValue());
        return $command;
    }
}
