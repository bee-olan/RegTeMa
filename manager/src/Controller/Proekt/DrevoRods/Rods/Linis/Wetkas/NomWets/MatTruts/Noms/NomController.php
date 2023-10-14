<?php

declare(strict_types=1);

namespace App\Controller\Proekt\DrevoRods\Rods\Linis\Wetkas\NomWets\MatTruts\Noms;

use App\Annotation\Guid;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\MatTrut;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Id;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet;


//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\NomFetcher;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/drevorods/rods/linis/wetkas/nomwets/mattruts/{id}/noms", name="app.proekts.drevorods.rods.rodrods.linis.wetkas.nomwets.mattruts.noms")
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
     * @param MatTrut $mattrut
     * @param Request $request
     * @param NomFetcher $noms
     * @return Response
     */
    public function index( Request $request, MatTrut $mattrut,  NomFetcher $noms): Response
    {
        $nomwet = $mattrut->getNomwet();
        $wetka = $nomwet->getWetka();
        $linia = $wetka->getLinia();
        $rodo =  $linia->getRodo();
        return $this->render('app/proekts/drevorods/rods/linis/wetkas/nomwets/mattruts/noms/index.html.twig', [
            'mattrut' => $mattrut,
            'wetka' => $wetka,
            'nomwet' => $nomwet,
            'linia' => $linia,
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa(),
            'noms' => $noms->allOfMatTrut($mattrut->getId()->getValue()),
        ]);
    }

}

