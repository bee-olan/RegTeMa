<?php

declare(strict_types=1);

namespace App\Controller\Proekt\DrevoRods;

use App\Annotation\Guid;
use App\Model\Drevos\Entity\Rass\Ras;
use App\Model\Drevos\UseCase\Rass\Create;
use App\Model\Drevos\UseCase\Rass\Edit;
use App\Model\Drevos\UseCase\Rass\Remove;
use App\ReadModel\Drevos\Rass\RasFetcher;
use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\Rods\RodFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("app/proekts/drevorods/rodras", name="app.proekts.drevorods.rodras")
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
     * @Route("", name="")
     * @param RasFetcher $fetcher
     * @param RodFetcher $fetcherRod
     * @return Response
     */
    public function rodras(RasFetcher $fetcher, RodFetcher $fetcherRod): Response
    {
       $rasas = $fetcher->all();

        $rods = $fetcherRod->all();

        return $this->render('app/proekts/drevorods/rodras.html.twig',
                                compact('rasas', 'rods'));
    }

}
