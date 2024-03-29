<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\ChildMatka\Status;


use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatka;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $actor;

    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank()
     */
    public $status;

    public function __construct(string $actor, int $id)
    {
        $this->actor = $actor;
        $this->id = $id;
    }

    public static function fromChildMatka(string $actor,  ChildMatka $childmatka): self
    {
        $command = new self($actor, $childmatka->getId()->getValue());
        $command->status = $childmatka->getStatus()->getName();

        return $command;
    }
}


