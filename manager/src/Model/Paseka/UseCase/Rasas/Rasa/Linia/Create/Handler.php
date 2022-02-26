<?php

// declare(strict_types=1);

// namespace App\Model\Matkis\UseCase\Rasas\Rasa\Linia\Create;

// use App\Model\Flusher;
// use App\Model\Matkis\Entity\Rasas\Rasa\Linia\Id;
// use App\Model\Matkis\Entity\Rasas\Rasa\Id as RasaId;
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
//         $rasa = $this->rasas->get(new RasaId($command->rasa));

//         $rasa->addLinia(
//             Id::next(),
//             $command->name
//         );

//         $this->flusher->flush();
//     }
// }
