<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\ChildDrevs;

use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrev;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;

use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Executor;
use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Plan;

use App\Controller\ErrorHandler;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("proekt/pasekas/childmatkas", name="proekt.pasekas.childmatkas")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildAssignController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/{id}/assign", name=".assign")
     * @param ChildDrev $childmatka
     * @param Request $request
     * @param Executor\Assign\Handler $handler
     * @return Response
     */
    public function assign(ChildDrev $childmatka, Request $request, Executor\Assign\Handler $handler): Response
    {
        $plemmatka = $childmatka->getPlemMatka();
        
       // $this->denyAccessUnlessGranted(TaskAccess::MANAGE, $task);

        $command = new Executor\Assign\Command($this->getUser()->getId(), $childmatka->getId()->getValue());
// dd  ($command);
        $form = $this->createForm(Executor\Assign\Form::class, $command, ['plemmatka_id' => $plemmatka->getId()->getValue()]);
      
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('proekt/pasekas/childmatkas/assign.html.twig', [
            'plemmatka' => $plemmatka,
            'childmatka' => $childmatka,
            'form' => $form->createView(),
        ]);
    }

    // revoke отменять
    /**
     * @Route("/{id}/revoke/{uchastie_id}", name=".revoke", methods={"POST"})
     * @ParamConverter("uchastie", options={"id" = "uchastie_id"})
     * @param ChildDrev $childmatka
     * @param Uchastie $uchastie
     * @param Request $request
     * @param Executor\Revoke\Handler $handler
     * @return Response
     */
    public function revoke(ChildDrev $childmatka, Uchastie $uchastie, Request $request, Executor\Revoke\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('revoke', $request->request->get('token'))) {
            return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        // $this->denyAccessUnlessGranted(ChildDrevAccess::MANAGE, $childmatka);

        $command = new Executor\Revoke\Command(
            $this->getUser()->getId(),
            $childmatka->getId()->getValue(),
            $uchastie->getId()->getValue()
        );

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
    }
}
