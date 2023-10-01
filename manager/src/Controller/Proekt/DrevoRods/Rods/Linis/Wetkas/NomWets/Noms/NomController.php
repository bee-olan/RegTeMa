<?php

declare(strict_types=1);

namespace App\Controller\Proekt\DrevoRods\Rods\Linis\Wetkas\NomWets\Noms;

use App\Annotation\Guid;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Noms\Id;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Wetka;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Noms\Create;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Noms\Edit;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Noms\Remove;

//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\NomWets\Noms\NomFetcher;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/drevorods/rods/linis/wetkas/nomwets/{id}/noms", name="app.proekts.drevorods.rods.rodrods.linis.wetkas.nomwets.noms")
 */
class NomController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param NomWet $nomwet
     * @param Request $request
     * @param NomFetcher $noms
     * @return Response
     */
    public function index( Request $request, NomWet $nomwet,  NomFetcher $noms): Response
    {
        $wetka = $nomwet->getWetka();
        $linia = $wetka->getLinia();
        $rodo =  $linia->getRodo();
        return $this->render('app/proekts/drevorods/rods/linis/wetkas/nomwets/noms/index.html.twig', [
            'wetka' => $wetka,
            'nomwet' => $nomwet,
            'linia' => $linia,
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa()->getName(),
            'noms' => $noms->allOfNomWet($nomwet->getId()->getValue()),
        ]);
    }

}

