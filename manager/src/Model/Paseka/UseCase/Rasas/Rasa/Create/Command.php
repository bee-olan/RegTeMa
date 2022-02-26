<?php

declare(strict_types=1);

namespace App\Model\Matkis\UseCase\Rasas\Rasa\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $name;
    /**
     * @Assert\NotBlank()
     */
    public $sort;
}
