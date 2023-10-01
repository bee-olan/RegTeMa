<?php

declare(strict_types=1);

namespace App\Controller\Proekt\DrevoRods\Rods\Linis;

use App\Annotation\Guid;

use App\Model\Drevos\Entity\Strans\StranRepository;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Create;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Edit;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Remove;

//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use App\Model\Drevos\Entity\Rass\Rods\Rod;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Id;
use App\ReadModel\Drevos\Rass\Rods\Linis\LiniFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/drevorods/rods/rodrods/{id}/linis", name="app.proekts.drevorods.rods.rodrods.linis")
 */
class LiniController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param Rod $rodo
     * @param Request $request
     * @param LiniFetcher $linias
     * @return Response
     */
    public function index( Request $request, Rod $rodo,  LiniFetcher $liniasf): Response
    {
//dd(allOfRodo($rodo->getId()->getValue()));
        return $this->render('app/proekts/drevorods/rods/rodrods/linis/index.html.twig', [
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa()->getName(),
            'linias' => $liniasf->allOfRodo($rodo->getId()->getValue())
//            allOfRodo($rodo->getId()->getValue()),
        ]);
    }

}
