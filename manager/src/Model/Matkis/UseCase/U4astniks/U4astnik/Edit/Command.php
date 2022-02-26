<?php

declare(strict_types=1);

namespace App\Model\Matkis\UseCase\U4astniks\U4astnik\Edit;

use App\Model\Matkis\Entity\U4astniks\U4astnik\U4astnik;
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

    public static function fromU4astnik(U4astnik $u4astnik): self
    {
        $command = new self($u4astnik->getId()->getValue());
        $command->firstName = $u4astnik->getName()->getFirst();
        $command->lastName = $u4astnik->getName()->getLast();
        $command->email = $u4astnik->getEmail()->getValue();
        return $command;
    }
}
