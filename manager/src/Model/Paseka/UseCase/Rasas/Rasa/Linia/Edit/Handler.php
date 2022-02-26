<?php

// declare(strict_types=1);

// namespace App\Model\Matkis\UseCase\Rasas\Rasa\Linia\Edit;

// use App\Model\Flusher;
// use App\Model\Matkis\Entity\Rasas\Rasa\Linia\Id as LiniaId;
// use App\Model\Matkis\Entity\Rasas\Rasa\Id;
// use App\Model\Matkis\Entity\Rasas\Rasa\RasaRepository;

// class Handler
// {
//     private $rasas;
//     private $flusher;

//     public function __construct(RasaRepository $rasas, Flusher $flusher)
//     {
//         $this->rasas = $rasas;
//         $this->flusher = $flusher;
//     }

//     public function handle(Command $command): void
//     {
//         $rasa = $this->rasas->get(new Id($command->rasa));

//         $rasa->editLinia(new LiniaId($command->id), $command->name);

//         $this->flusher->flush();
//     }
// }

