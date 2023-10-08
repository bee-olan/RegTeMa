<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $nomwet;

    /**
     * @Assert\NotBlank()
     */
    public $id;

    public function __construct(string $nomwet, string $id)
    {
        $this->nomwet = $nomwet;
        $this->id = $id;
    }
}

