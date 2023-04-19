<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\MatTests\PlemTest\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $star_linia;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $star_nomer;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $title;


    /**
     * @Assert\NotBlank()
     */
    public $goda_vixod;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
