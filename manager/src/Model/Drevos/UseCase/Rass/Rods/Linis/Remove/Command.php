<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $rodo;
    /**
     * @Assert\NotBlank()
     */
    public $id;

    public function __construct(string $rodo, string $id)
    {
        $this->rodo = $rodo;
        $this->id = $id;
    }
}

