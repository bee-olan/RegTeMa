<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\UchasDrev\Add;

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
    public $sezondrevs;


    public function __construct(string $plemmatka)
    {
        $this->plemmatka = $plemmatka;
    }
}
