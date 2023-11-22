<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Create;

//use App\Model\Adminka\Entity\Matkas\ChildMatka\Type;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $plemmatka;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $uchastie;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $otecNomer;

    /**
     * @var string
     */
    public $content;

    /**
     * @var int
     */
    public $parent;

    /**
     * @var \DateTimeImmutable
     * @Assert\Date()
     */
    public $plan_date;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $type;

    /**
     * @Assert\NotBlank()
     */
    public $priority;



    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $sezonPlem;

//    /**
//     * @var string
//     * @Assert\NotBlank()
//     */
//    public $sezonChild;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public $kolChild;

    public function __construct(string $plemmatka, string $uchastie, string $sezonPlem)
    {
        $this->plemmatka = $plemmatka;
        $this->uchastie = $uchastie;
        $this->sezonPlem = $sezonPlem;
        $this->kolChild = 1;
        $this->priority = 2;

    }
}
