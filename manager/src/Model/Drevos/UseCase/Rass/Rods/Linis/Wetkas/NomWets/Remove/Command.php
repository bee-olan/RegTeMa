<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $wetka;

    /**
     * @Assert\NotBlank()
     */
    public $id;

    public function __construct(string $wetka, string $id)
    {
        $this->wetka = $wetka;
        $this->id = $id;
    }
}

