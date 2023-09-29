<?php


namespace App\Controller\Proekt\DrevoRods;


use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\RasFetcher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DreRasaController  extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/app/proekts/drevorods/drerasa", name="app.proekts.drevorods.drerasa")
     * @param RasFetcher $fetcher

     * @return Response
     */
    public function dreRasa(RasFetcher $fetcher): Response
    {
        $rasas = $fetcher->all();

// dd($rasas);
        return $this->render('app/proekts/drevorods/drerasa.html.twig',
            compact('rasas'));
    }

}
