<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Priority;

use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrev;

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
    public $priority;

    public function __construct(string $actor, int $id)
    {
        $this->actor = $actor;
        $this->id = $id;
    }

    public static function fromChildDrev(string $actor, ChildDrev $childmatka): self
    {
        $command = new self($actor, $childmatka->getId()->getValue());
        $command->priority = $childmatka->getPriority();
        return $command;
    }
}


