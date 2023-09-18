<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rass\Ras;

use App\Annotation\Guid;
use App\Controller\ErrorHandler;

use App\Model\Drevos\UseCase\Rass\Remove;
use App\Model\Drevos\Entity\Rass\Ras;
use App\ReadModel\Drevos\Rass\Rods\RodFetcher;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drevos/{rasa_id}/rass", name="drevos.rass")
 */
class RasController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
      * @Route("", name=".show", requirements={"id"=Guid::PATTERN})
      * @param Ras $rasa
      * @param RodFetcher $fetcher
      * @return Response
      */
      public function show(Ras $rasa, RodFetcher $fetcher): Response
      {
          $rodos = $fetcher->allOfRasa($rasa->getId()->getValue());

        return $this->render('app/drevos/rass/rods/index.html.twig',
                                            compact('rasa', 'rodos'));
    
    }

    /**
     * @Route("/delete", name=".delete", methods={"POST"})
     * @param Ras $rasa
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Ras $rasa, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('drevos.rass', ['id' => $rasa->getId()]);
        }

        //$this->denyAccessUnlessGranted(MateriAccess::EDIT, $rasas);

        $command = new Remove\Command($rasa->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drevos.rass');
    }	


}
