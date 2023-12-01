<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\NomerBrs\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $vetka;
    /**
     * @Assert\NotBlank()
     */
    public $id;

    public function __construct(string $vetka, string $id)
    {
        $this->vetka = $vetka;
        $this->id = $id;
    }
}

