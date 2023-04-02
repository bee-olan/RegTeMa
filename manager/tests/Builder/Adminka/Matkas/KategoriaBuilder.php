<?php

declare(strict_types=1);

namespace App\Tests\Builder\Adminka\Matkas;


use App\Model\Adminka\Entity\Matkas\Kategoria\Id;
use App\Model\Adminka\Entity\Matkas\Kategoria\Kategoria;

class KategoriaBuilder
{
    private $name;
    private $permissions;

    public function __construct()
    {
        $this->name = 'н';
        $this->permissions = [];
    }

    public function build(): Kategoria
    {
        return new Kategoria(
            Id::next(),
            $this->name,
            $this->permissions
        );
    }
}