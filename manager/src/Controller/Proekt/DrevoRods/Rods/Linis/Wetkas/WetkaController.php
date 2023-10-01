<?php

declare(strict_types=1);

namespace App\Controller\Proekt\DrevoRods\Rods\Linis\Wetkas;

use App\Annotation\Guid;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Lini;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Id;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\Create;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\Edit;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\Remove;

//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\WetkaFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/drevorods/rods/linis/{id}/wetkas", name="app.proekts.drevorods.rods.rodrods.linis.wetkas")
 */
class WetkaController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param Lini $linia
     * @param Request $request
     * @param WetkaFetcher $wetkas
     * @return Response
     */
    public function index( Request $request, Lini $linia,  WetkaFetcher $wetkas): Response
    {
        $rodo = $linia->getRodo();
        return $this->render('app/proekts/drevorods/rods/linis/wetkas/index.html.twig', [
            'linia' => $linia,
            'rodo' => $rodo,
            'rasa' => $rodo->getRasa(),
            'stran' => $rodo->getStrana(),
            'wetkas' => $wetkas->allOfLinia($linia->getId()->getValue()),
        ]);
    }

}