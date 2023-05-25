<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\IzChildPlems\CreateAssign;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $plemmatka;

    /**
     * @Assert\NotBlank()
     */
    public $uchastie;

    /**
     * @Assert\NotBlank()
     */
    public $departments;
    /**
     * @Assert\NotBlank()
     */
    public $roles;

    /**
     * @Assert\NotBlank()
     */
    public $childId;

    public function __construct(string $plemmatka, int  $childId)
    {
        $this->plemmatka = $plemmatka;
        $this->childId = $childId;
    }
}
