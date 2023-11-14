<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\UchasDrev\Edit;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka;
use App\Model\Adminka\Entity\DrevMatkas\SezonDrev\SezonDrev;
use App\Model\Adminka\Entity\DrevMatkas\UchasDrev;

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

    public function __construct(string $plemmatka, string $uchastie)
    {
        $this->plemmatka = $plemmatka;
        $this->uchastie = $uchastie;
    }

    public static function fromUchasDrev(DrevMatka $plemmatka, UchasDrev $uchasdrev): self
    {
        $command = new self($plemmatka->getId()->getValue(), $uchasdrev->getUchastie()->getId()->getValue());
        $command->sezondrevs = array_map(static function (SezonDrev $sezondrev): string {
            return $sezondrev->getId()->getValue();
        }, $uchasdrev->getSezonDrevs());
//        $command->roles = array_map(static function (Role $role): string {
//            return $role->getId()->getValue();
//        }, $uchasdrev->getRoles());
        return $command;
    }
}
