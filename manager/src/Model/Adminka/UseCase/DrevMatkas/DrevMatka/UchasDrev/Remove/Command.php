<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\UchasDrev\Remove;

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

    public function __construct(string $plemmatka, string $uchastie)
    {
        $this->plemmatka = $plemmatka;
        $this->uchastie = $uchastie;
    }
}
