<?php

declare(strict_types=1);

namespace App\ReadModel\Matkis\U4astniks\U4astnik\Filter;

use App\Model\Matkis\Entity\U4astniks\U4astnik\Status;

class Filter
{
    public $name;
    public $email;
    public $group;
    public $status = Status::ACTIVE;
}
