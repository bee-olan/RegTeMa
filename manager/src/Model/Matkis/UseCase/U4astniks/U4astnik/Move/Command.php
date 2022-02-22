<?php

declare(strict_types=1);

namespace App\Model\Matkis\UseCase\U4astniks\U4astnik\Move;

use App\Model\Matkis\Entity\U4astniks\U4astnik\U4astnik;
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

    public static function fromU4astnik(U4astnik $u4astnik): self
    {
        $command = new self($u4astnik->getId()->getValue());
        $command->group = $u4astnik->getGroup()->getId()->getValue();
        return $command;
    }
}
