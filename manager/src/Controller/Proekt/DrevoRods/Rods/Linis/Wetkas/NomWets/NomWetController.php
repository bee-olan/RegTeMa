<?php

declare(strict_types=1);

namespace App\Controller\Proekt\DrevoRods\Rods\Linis\Wetkas\NomWets;

use App\Annotation\Guid;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Id;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Wetka;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Create;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Edit;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Remove;

//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\NomWets\NomWetFetcher;
use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\WetkaFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/drevorods/rods/linis/wetkas/{id}/nomwets", name="app.proekts.drevorods.rods.rodrods.linis.wetkas.nomwets")
 */
class NomWetController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param Wetka $wetka
     * @param Request $request
     * @param NomWetFetcher $nomwets
     * @return Response
     */
    public function index( Request $request, Wetka $wetka,  NomWetFetcher $nomwets): Response
    {
        $linia = $wetka->getLinia();
        $rodo =  $linia->getRodo();
        return $this->render('app/proekts/drevorods/rods/linis/wetkas/nomwets/index.html.twig', [
            'wetka' => $wetka,
            'linia' => $linia,
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa()->getName(),
            'nomwets' => $nomwets->allOfWetka($wetka->getId()->getValue()),
        ]);
    }

}
