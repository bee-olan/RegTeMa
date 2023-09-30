<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rass\Ras;

use App\Annotation\Guid;
use App\Model\Drevos\Entity\Rass\Ras;
use App\Model\Drevos\UseCase\Rass\Create;
use App\Model\Drevos\UseCase\Rass\Edit;
use App\Model\Drevos\UseCase\Rass\Remove;
use App\ReadModel\Drevos\Rass\RasFetcher;
use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("app/drevos/rass", name="app.drevos.rass")
 */
// @IsGranted("ROLE_Adminka_MANAGE_MATERIS")

class RodRasController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/rodras", name=".rodras")
     * @param RasFetcher $fetcher
     * @return Response
     */
    public function rodras(RasFetcher $fetcher): Response
    {
       $rasas = $fetcher->all();
 //dd($rasas);      
  

        return $this->render('app/drevos/rass/rodras.html.twig',
                                compact('rasas'));
    }

}
