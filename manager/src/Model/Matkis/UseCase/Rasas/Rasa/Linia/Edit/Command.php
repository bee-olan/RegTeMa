<?php

// declare(strict_types=1);

// namespace App\Model\Matkis\UseCase\Rasas\Rasa\Linia\Edit;

// use App\Model\Matkis\Entity\Rasas\Rasa\Linia\Linia;
// use App\Model\Matkis\Entity\Rasas\Rasa\Rasa;
// use Symfony\Component\Validator\Constraints as Assert;

// class Command
// {
//     /**
//      * @Assert\NotBlank()
//      */
//     public $rasa;
//     /**
//      * @Assert\NotBlank()
//      */
//     public $id;
//     /**
//      * @Assert\NotBlank()
//      */
//     public $name;

//     public function __construct(string $rasa, string $id)
//     {
//         $this->rasa = $rasa;
//         $this->id = $id;
//     }

//     public static function fromLinia(Rasa $rasa, Linia $linia): self
//     {
//         $command = new self($rasa->getId()->getValue(), $linia->getId()->getValue());
//         $command->name = $linia->getName();
//         return $command;
//     }
// }
