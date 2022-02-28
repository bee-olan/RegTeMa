<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Rasa\Pcheloship\Add;

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
    /**
     * @Assert\NotBlank()
     */
    public $linias;
    /**
     * @Assert\NotBlank()
     */
    public $kategors;

    public function __construct(string $rasa)
    {
        $this->rasa = $rasa;
    }
}
