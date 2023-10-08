<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $mattrut;

    /**
     * @Assert\NotBlank()
     */
    public $id;

    public function __construct(string $mattrut, string $id)
    {
        $this->mattrut = $mattrut;
        $this->id = $id;
    }
}

