<?php

declare(strict_types=1);

namespace App\Tests\Builder\Adminka\Uchasties;


use App\Model\Adminka\Entity\Uchasties\Group\Group;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Email;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Name;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;

class UchastieBuilder
{
    private $name;
    private $email;
    private $nike;
    private $date;

    public function __construct()
    {
        $this->name = new Name('First', 'Last');
        $this->email = new Email('member@app.test');
        $this->nike = 'Nike';
    }

    public function build(Group $group): Uchastie
    {
        return new Uchastie(
            Id::next(),
            $date = new \DateTimeImmutable(),
            $group,
            $this->name,
            $this->email,
            $this->nike
        );
    }
}