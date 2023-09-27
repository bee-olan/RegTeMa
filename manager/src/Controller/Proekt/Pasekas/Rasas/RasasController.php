<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Rasas;

use App\Annotation\Guid;
use App\Model\Adminka\Entity\Rasas\Rasa;
use App\Model\Adminka\UseCase\Rasas\Create;


use App\ReadModel\Adminka\Rasas\RasaFetcher;

use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/rasas", name="app.proekts.pasekas.rasas")
 */
// @IsGranted("ROLE_Paseka_MANAGE_MATERIS")

class RasasController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


//    /**
//     * @Route("", name="")
//     * @param RasaFetcher $fetcher
//     * @return Response
//     */
//    public function index(RasaFetcher $fetcher): Response
//    {
//       $rasas = $fetcher->all();
// //dd($rasas);
//
//
//        return $this->render('app/proekts/pasekas/rasas/index.html.twig',
//                                compact('rasas'));
//    }

    /**
     * @Route("/plemmatka", name=".plemmatka")
     * @param RasaFetcher $fetcher

     * @return Response
     */
    public function plemmatka(RasaFetcher $fetcher): Response
    {
        $rasas = $fetcher->all();


        return $this->render('app/proekts/pasekas/rasas/plemmatka.html.twig',
            compact('rasas'));
    }

    /**
     * @Route("/create", name=".create")
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, Create\Handler $handler): Response
    {
        $command = new Create\Command();

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.rasas');
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/pasekas/rasas/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name=".show" , requirements={"id"=Guid::PATTERN})
     * @return Response
     */
    public function show(): Response
    {
        return $this->redirectToRoute('paseka.rasas');
    }
}
