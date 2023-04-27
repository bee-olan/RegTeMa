<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Create;

use App\Model\Flusher;
use App\Model\Adminka\Entity\OtecForRas\Rasa;
use App\Model\Adminka\Entity\Rasas\Id as RasaId;
use App\Model\Adminka\Entity\OtecForRas\Id;
use App\Model\Adminka\Entity\OtecForRas\RasaOtecRepository;
use App\Model\Adminka\Entity\Rasas\RasaRepository;

class Handler
{
    private $rasas;
    private $rasaOt;
    private $flusher;

    public function __construct(RasaRepository $rasas,RasaOtecRepository $rasaOt, Flusher $flusher)
    {
        $this->rasas = $rasas;
        $this->rasaOt = $rasaOt;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $id = new Id($command->name);

        if ($this->rasaOt->has($id)) {
            throw new \DomainException('Линия  уже существует !!. Выходим из режима Добавить');
        }

        $rasaa = $this->rasas->get(new RasaId($command->name)) ;



        $rasa = new Rasa(
            $id,
            $rasaa->getName(),
			$rasaa->getTitle()
        );

        $this->rasaOt->add($rasa);

        $this->flusher->flush();
    }
}
