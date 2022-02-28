<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Rasa\Pcheloship\Edit;

use App\Model\Paseka\Entity\Rasas\Rasa\Linia\Linia;
use App\Model\Paseka\Entity\Rasas\Rasa\Pcheloship;
use App\Model\Paseka\Entity\Rasas\Rasa\Rasa;
use App\Model\Paseka\Entity\Rasas\Kategor\Kategor;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $rasa;
    /**
     * @Assert\NotBlank()
     */
    public $pchelowod;
    /**
     * @Assert\NotBlank()
     */
    public $linias;
    /**
     * @Assert\NotBlank()
     */
    public $kategors;

    public function __construct(string $rasa, string $pchelowod)
    {
        $this->rasa = $rasa;
        $this->pchelowod = $pchelowod;
    }

    public static function fromMembership(Rasa $rasa, Pcheloship $pcheloship): self
    {
        $command = new self($rasa->getId()->getValue(), $pcheloship->getPchelowod()->getId()->getValue());
        $command->linias = array_map(static function (Linia $linia): string {
            return $linia->getId()->getValue();
        }, $pcheloship->getLinias());
        $command->kategors = array_map(static function (Kategor $kategor): string {
            return $kategor->getId()->getValue();
        }, $pcheloship->getKategors());
        return $command;
    }
}
