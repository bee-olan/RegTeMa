<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Pchelowods\Pchelowod\Edit;

use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Pchelowod;
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
    public $firstName;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $lastName;
    /**
     * @var string
     * @Assert\Email()
     */
    public $email;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromMember(Pchelowod $member): self
    {
        $command = new self($member->getId()->getValue());
        $command->firstName = $member->getName()->getFirst();
        $command->lastName = $member->getName()->getLast();
        $command->email = $member->getEmail()->getValue();
        return $command;
    }
}
