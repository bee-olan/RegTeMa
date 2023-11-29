<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\Create;

use App\Model\Drevos\Entity\Rass\LiniBr\LiniBr;

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
    public $nomer;

    /**
     * @Assert\NotBlank()
     */
    public $god;

	
	/**
     * @Assert\NotBlank()
     */
    public $sortVet;

    public function __construct( string $linia)
    {
        $this->linia = $linia;
    }

    public static function fromLiniBr(LiniBr $linia, int $maxSort): self
    {

        $command = new self($linia->getId()->getValue());
        $command->sortVet = $maxSort;

        return $command;
    }
}
