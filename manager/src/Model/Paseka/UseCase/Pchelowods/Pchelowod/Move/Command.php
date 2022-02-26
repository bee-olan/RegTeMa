<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Pchelowods\Pchelowod\Move;

use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Pchelowod;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank()
     */
    public $group;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromMember(Pchelowod $member): self
    {
        $command = new self($member->getId()->getValue());
        $command->group = $member->getGroup()->getId()->getValue();
        return $command;
    }
}
