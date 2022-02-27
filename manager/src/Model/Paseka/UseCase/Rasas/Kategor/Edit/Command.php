<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Kategor\Edit;

use App\Model\Paseka\Entity\Rasas\Kategor\Permission;
use App\Model\Paseka\Entity\Rasas\Kategor\Kategor;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;
    /**
     * @var string[]
     */
    public $permissions;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromRole(Kategor $kategor): self
    {
        $command = new self($kategor->getId()->getValue());
        $command->name = $kategor->getName();
        $command->permissions = array_map(static function (Permission $permission): string {
            return $permission->getName();
        }, $kategor->getPermissions());
        return $command;
    }
}
