<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Strans\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;
	
	 /**
     * @var int
     * @Assert\NotBlank()
     */
    public $nomer;
}