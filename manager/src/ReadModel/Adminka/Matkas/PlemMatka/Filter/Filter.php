<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Matkas\PlemMatka\Filter;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Status;

class Filter
{
    public $name;
    public $persona;
    public $status = Status::ACTIVE;
    public $god_vixod;
}