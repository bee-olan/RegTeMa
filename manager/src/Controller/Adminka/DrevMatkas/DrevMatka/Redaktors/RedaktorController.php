<?php

declare(strict_types=1);

namespace App\Controller\Adminka\DrevMatkas\DrevMatka\Redaktors;

use App\Annotation\Guid;


use App\Controller\ErrorHandler;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\DrevMatka;
use App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\Edit;
use App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\Archive;
use App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\Reinstate;
use App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\Remove;


use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/drevmatkas/drevmatka/{plemmatka_id}/redaktors", name="adminka.drevmatkas.drevmatka.redaktors")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class RedaktorController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="", requirements={"id"=Guid::PATTERN})
     * @param DrevMatka $plemmatka
     * @return Response
     */
    public function index(DrevMatka $plemmatka): Response
    {
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $plemmatka);
//        $departamens = $plemmatka->getDepartments();
        return $this->render('app/adminka/drevmatkas/drevmatka/redaktors/index.html.twig',
            compact('plemmatka'));
    }

    /**
     * @Route("/edit", name=".edit")
     * @param DrevMatka $plemmatka
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(DrevMatka $plemmatka, Request $request, Edit\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $plemmatka);

        $command = Edit\Command::fromDrevMatka($plemmatka);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors', ['id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/drevmatkas/drevmatka/redaktors/edit.html.twig', [
            'plemmatka' => $plemmatka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/archive", name=".archive", methods={"POST"})
     * @param DrevMatka $plemmatka
     * @param Request $request
     * @param Archive\Handler $handler
     * @return Response
     */
    public function archive(DrevMatka $plemmatka, Request $request, Archive\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors', ['id' => $plemmatka->getId()]);
        }

//        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $plemmatka);

        $command = new Archive\Command($plemmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors', ['plemmatka_id' => $plemmatka->getId()]);
    }

    /**
     * @Route("/reinstate", name=".reinstate", methods={"POST"})
     * @param DrevMatka $plemmatka
     * @param Request $request
     * @param Reinstate\Handler $handler
     * @return Response
     */
    public function reinstate(DrevMatka $plemmatka, Request $request, Reinstate\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors', ['plemmatka_id' => $plemmatka->getId()]);
        }
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $plemmatka);


        $command = new Reinstate\Command($plemmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors', ['plemmatka_id' => $plemmatka->getId()]);
    }

    /**
     * @Route("/delete", name=".delete", methods={"POST"})
     * @param DrevMatka $plemmatka
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(DrevMatka $plemmatka, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.matkas.plemmatka.settings', ['plemmatka_id' => $plemmatka->getId()]);
        }
        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $plemmatka);

        $command = new Remove\Command($plemmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.drevmatkas');
    }
}