<?php

declare(strict_types=1);

namespace App\Model\Matkis\UseCase\Rasas\Rasa\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
