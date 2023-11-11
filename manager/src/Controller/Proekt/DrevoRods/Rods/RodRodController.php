<?php

declare(strict_types=1);

namespace App\Controller\Proekt\DrevoRods\Rods;


use App\Controller\ErrorHandler;
use App\Model\Drevos\Entity\Rass\Ras;
use App\ReadModel\Drevos\Rass\RasFetcher;
use App\ReadModel\Drevos\Rass\Rods\RodFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/drevorods/rods/{id}/rodrods", name="app.proekts.drevorods.rods.rodrods")
 */
class RodRodController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param Ras $rasa
     * @param Request $request
     * @param RodFetcher $rodos
     * @param RasFetcher $fetcher,
     * @return Response
     */
    public function rodrod( Request $request, Ras $rasa, RasFetcher $fetcher, RodFetcher $rodosf): Response
    {

        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);
        $rasas = $fetcher->all();

        return $this->render('app/proekts/drevorods/rods/rodrods.html.twig', [
            'rasa' => $rasa,
            'rodos' => $rodosf->allOfRasa($rasa->getId()->getValue()),
        ]);
    }
}
