<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Create;

use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchatieId;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\MatTrutRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Id as MatTrutId;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Id;

use App\Model\Flusher;

use App\Model\Adminka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Adminka\Entity\Sezons\Godas\Id as GodaId;

use Symfony\Component\Routing\Annotation\Route;

class Handler
{
    private $godas;
    private $mattruts;
    private $uchasties;
    private $flusher;

    public function __construct(MatTrutRepository $mattruts,
                                GodaRepository $godas,
                                UchastieRepository $uchasties,
                                Flusher $flusher)
    {
        $this->godas = $godas;
        $this->mattruts = $mattruts;
        $this->uchasties= $uchasties;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $mattrut = $this->mattruts->get(new MatTrutId($command->mattrut));
        $nomwet = $mattrut->getNomwet()->getGodW();
//        dd($nomwet);
        $zakazal = $this->uchasties->get(new UchatieId($command->zakaz));

        $goda = $this->godas->get(new GodaId($command->god));

        $god = (string)$goda->getGod();

        $command->tit = $command->nom."-".$god;

//        if ( $this->liniaRepos->hasLini($command->name)){
//
//            $liniaRepos= $this->liniaRepos->getLiniId($command->name);
//            $command->id = $liniaRepos;
//
//        } else {
//
//            $rodo->addLini(
//                $command->id = Id::next(),
//                $command->name ,
//                $command->sortLini
//            );
//        }
        if ( (int)$god < (int)$nomwet ){
            throw new \DomainException('Внимание! Исправьте год выхода матки. Дочь не может быть старше матери .');
//            $this->addFlash('error', 'Внимание!!! Пожалуйста, начните с этого! ');
//            return $this->redirectToRoute('app.proekts.pasekas.uchasties.uchastiee');
        }
     $mattrut->addNom(
         $command->id = Id::next(),
			$command->nom,
			$god,
			$command->tit,
			$command->sortNom,
            $zakazal
        );


        $this->flusher->flush();
    }
}
