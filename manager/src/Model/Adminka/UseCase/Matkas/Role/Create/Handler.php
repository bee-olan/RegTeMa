<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\Role\Create;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Matkas\Role\Role;
use App\Model\Adminka\Entity\Matkas\Role\Id;
use App\Model\Adminka\Entity\Matkas\Role\RoleRepository;

class Handler
{
    private $roles;
    private $flusher;

    public function __construct(RoleRepository $roles, Flusher $flusher)
    {
        $this->roles = $roles;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if ($this->roles->hasByName($command->name)) {
            throw new \DomainException('Роль уже существует.');
        }

        $role = new Role(
            Id::next(),
            $command->name,
            $command->permissions
        );

        $this->roles->add($role);

        $this->flusher->flush();
    }
}
