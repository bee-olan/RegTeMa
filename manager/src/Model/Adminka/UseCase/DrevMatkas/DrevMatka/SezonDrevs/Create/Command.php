<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\SezonDrevs\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $plemmatka;
//    /**
//     * @Assert\NotBlank()
//     */
//    public $name;

    public function __construct(string $plemmatka)
    {
        $this->plemmatka = $plemmatka;
    }
}
