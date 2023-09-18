<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Strans\Edit;


use App\Model\Drevos\Entity\Strans\Stran;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public $nomer;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromStran(Stran $strana): self
    {
        $command = new self($strana->getId()->getValue());
        $command->name = $strana->getName();
		$command->nomer = $strana->getNomer();
        return $command;
    }
}
