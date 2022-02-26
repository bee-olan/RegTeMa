<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Pchelowods\Pchelowod\Filter;

use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Status;

class Filter
{
    public $name;
    public $email;
    public $group;
    public $status = Status::ACTIVE;
}
