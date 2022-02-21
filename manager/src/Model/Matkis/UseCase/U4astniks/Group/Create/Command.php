<?php

declare(strict_types=1);

namespace App\Model\Matkis\UseCase\U4astniks\Group\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;
}