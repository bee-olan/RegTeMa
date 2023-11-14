<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\UchasDrev\EditSez;

use App\Model\Adminka\Entity\Matkas\PlemMatka\Department\Department;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Adminka\Entity\Matkas\PlemMatka\Uchastnik;
use App\Model\Adminka\Entity\Matkas\Role\Role;

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
    public $departments;
//    /**
//     * @Assert\NotBlank()
//     */
//    public $roles;

    public function __construct(string $plemmatka, string $uchastie)
    {
        $this->plemmatka = $plemmatka;
        $this->uchastie = $uchastie;
    }

    public static function fromUchastnik(PlemMatka $plemmatka, Uchastnik $uchasnik): self
    {
        $command = new self($plemmatka->getId()->getValue(), $uchasnik->getUchastie()->getId()->getValue());
        $command->departments = array_map(static function (Department $department): string {
            return $department->getId()->getValue();
        }, $uchasnik->getDepartments());

//        $command->roles = array_map(static function (Role $role): string {
//            return $role->getId()->getValue();
//        }, $uchasnik->getRoles());

        return $command;
    }
}
