<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;
	
//	 /**
//     * @var string
//     * @Assert\NotBlank()
//     */
//    public $title;
}