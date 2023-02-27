<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\Role\Edit;

use App\Model\Flusher;
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
        $role = $this->roles->get(new Id($command->id));

        $role->edit($command->name, $command->permissions);

        $this->flusher->flush();
    }
}
