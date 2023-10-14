<?php

declare(strict_types=1);

namespace App\Controller\Proekt\DrevoRods\Rods\Linis\Wetkas\NomWets\MatTruts;

use App\Annotation\Guid;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet;

//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\MatTrutFetcher;
use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\NomWets\NomWetFetcher;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/drevorods/rods/linis/wetkas/nomwets/{id}/mattruts", name="app.proekts.drevorods.rods.linis.wetkas.nomwets.mattruts")
 */
class MatTrutController extends AbstractController
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
     * @param MatTrutFetcher $mattruts
     * @return Response
     */
    public function index( Request $request, NomWet $nomwet,  NomWetFetcher $mattruts): Response
    {
        $wetka = $nomwet->getWetka();
        $linia = $wetka->getLinia();
        $rodo =  $linia->getRodo();
        return $this->render('app/proekts/drevorods/rods/linis/wetkas/nomwets/mattruts/index.html.twig', [
            'wetka' => $wetka,
            'linia' => $linia,
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa(),
            'nomwet' => $nomwet,
            'mattruts' => $mattruts->allOfNomWet($nomwet->getId()->getValue()),
        ]);
    }

}
