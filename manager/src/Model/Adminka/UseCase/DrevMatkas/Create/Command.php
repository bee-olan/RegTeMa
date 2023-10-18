<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
//    /**
//     * @var string
//     * @Assert\NotBlank()
//     */
//    public $otecNomer;

    /**
     * @Assert\NotBlank()
     */
    public $sort;

//    /**
//     * @var string
//     * @Assert\NotBlank()
//     */
//    public $uchastieId;


//    /**
//     * @var string
//     * @Assert\NotBlank()
//     */
//    public $title;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $nomer;


//    /**
//     * @Assert\NotBlank()
//     */
//    public $kategoria;

    public function __construct(  int $sort, string $nomer )
    {
        $this->nomer=$nomer;
        $this->sort = $sort;
//        $this->uchastieId = $uchastieId;
    }
}
