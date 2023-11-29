<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\Edit;

use App\Model\Drevos\Entity\Rass\LiniBr\LiniBr;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\VetkaBr;
use App\Model\Drevos\Entity\Rass\Ras;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $linia;
	
    /**
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @Assert\NotBlank()
     */
    public $nomer;

    /**
     * @Assert\NotBlank()
     */
    public $god;

    public function __construct(string $linia, string $id)
    {
        $this->linia = $linia;
        $this->id = $id;
    }

    public static function fromVetBr(LiniBr $linia, VetkaBr $vetka): self
    {
        $command = new self($linia->getId()->getValue(), $vetka->getId()->getValue());
        $command->nomer = $vetka->getNomer();
        $command->god = $vetka->getGod();
        return $command;
    }
}
