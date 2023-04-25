<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\PlemMatka\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
//    /**
//     * @Assert\NotBlank()
//     */
//    public $name;

    /**
     * @Assert\NotBlank()
     */
    public $sort;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $uchastieId;

//    /**
//     * @var string
//     * @Assert\NotBlank()
//     */
//    public $rasaNomId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $title;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $nomer;

//    /**
//     * @Assert\NotBlank()
//     */
//    public $persona;

//    /**
//     * @var string
//     * @Assert\NotBlank()
//     */
//    public $goda;

    /**
     * @Assert\NotBlank()
     */
    public $kategoria;

    public function __construct( string $uchastieId, int $sort, string $nomer )
    {
        $this->nomer=$nomer;
        $this->sort = $sort;
        $this->uchastieId = $uchastieId;
    }
}
