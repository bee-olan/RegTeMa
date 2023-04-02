<?php

declare(strict_types=1);

namespace App\Tests\Builder\Adminka\Uchasties;


use App\Model\Adminka\Entity\Uchasties\Group\Group;
use App\Model\Adminka\Entity\Uchasties\Group\Id;

class GroupBuilder
{
    private $name;

    public function __construct()
    {
        $this->name = 'Group';
    }

    public function build(): Group
    {
        return new Group(
            Id::next(),
            $this->name
        );
    }
}