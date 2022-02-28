<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Rasa\Pcheloship\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $rasa;
    /**
     * @Assert\NotBlank()
     */
    public $pchelowod;

    public function __construct(string $rasa, string $pchelowod)
    {
        $this->rasa = $rasa;
        $this->pchelowod = $pchelowod;
    }
}
