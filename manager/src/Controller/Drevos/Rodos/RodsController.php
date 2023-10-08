<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rodos;

use App\Annotation\Guid;

use App\Controller\ErrorHandler;

use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\NomFetcher;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drevos/rodos", name="drevos.rodos")
 */
class RodsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param NomFetcher $nomFets
     * @return Response
     */
    public function index( NomFetcher $nomFets): Response
    {


        return $this->render('app/drevos/rodos/index.html.twig', [
//            'linia' => $linia,
            'noms' => $nomFets->all(),

        ]);
    }


}