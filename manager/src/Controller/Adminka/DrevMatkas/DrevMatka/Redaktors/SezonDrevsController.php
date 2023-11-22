<?php

declare(strict_types=1);

namespace App\Controller\Adminka\DrevMatkas\DrevMatka\Redaktors;

use App\Annotation\Guid;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\SezonDrev\Id;
//
use  App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\SezonDrevs\Create;
use  App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\SezonDrevs\Edit;
use  App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\SezonDrevs\Remove;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\DrevMatka;
use App\ReadModel\Adminka\DrevMatkas\SezonDrevFetcher;
use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/drevmatkas/drevmatka/{plemmatka_id}/redaktors/sezondrevs", name="adminka.drevmatkas.drevmatka.redaktors.sezondrevs")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 * @IsGranted("ROLE_ADMINKA_MANAGE_PLEMMATKAS")
 */
class SezonDrevsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param DrevMatka $plemmatka
     * @param SezonDrevFetcher $sezonDrevs
     * @return Response
     */
    public function index(DrevMatka $plemmatka, SezonDrevFetcher $sezonDrevs): Response
    {
//        $this->denyAccessUnlessGranted(DrevMatkaAccess::MANAGE_UCHASTIES, $plemmatka);
//dd($sezonDrevs->allOfDrevMatka($plemmatka->getId()->getValue()));
        return $this->render('app/adminka/drevmatkas/drevmatka/redaktors/sezondrevs/index.html.twig', [
            'plemmatka' => $plemmatka,
            'sezonDrevs' => $sezonDrevs->allOfDrevMatka($plemmatka->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param DrevMatka $plemmatka
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(DrevMatka $plemmatka, Request $request, Create\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(DrevMatkaAccess::MANAGE_UCHASTIES, $plemmatka);

        $command = new Create\Command($plemmatka->getId()->getValue());

            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors.sezondrevs', ['plemmatka_id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }

        return $this->render('app/adminka/drevmatkas/drevmatka/redaktors/sezondrevs/create.html.twig', [
            'plemmatka' => $plemmatka,
//            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param DrevMatka $plemmatka
     * @param string $id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(DrevMatka $plemmatka, string $id, Request $request, Edit\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(DrevMatkaAccess::MANAGE_UCHASTIES, $plemmatka);

        $sezondrev = $plemmatka->getSezondrev(new Id($id) );

        $command = Edit\Command::fromSezonDrev($plemmatka, $sezondrev);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors.sezondrevs.show', ['plemmatka_id' => $plemmatka->getId(), 'id' => $id]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/drevmatkas/drevmatka/redaktors/sezondrevs/edit.html.twig', [
            'plemmatka' => $plemmatka,
            'sezondrev' => $sezondrev,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param DrevMatka $plemmatka
     * @param string $id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(DrevMatka $plemmatka, string $id, Request $request, Remove\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(DrevMatkaAccess::MANAGE_UCHASTIES, $plemmatka);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors.sezondrevs', ['plemmatka_id' => $plemmatka->getId()]);
        }

        $sezondrev = $plemmatka->getSezondrev(new Id($id));

        $command = new Remove\Command($plemmatka->getId()->getValue(), $sezondrev->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors.sezondrevs', ['plemmatka_id' => $plemmatka->getId()]);
    }

    /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN}))
     * @param DrevMatka $plemmatka
     * @return Response
     */
    public function show(DrevMatka $plemmatka): Response
    {
        return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors.sezondrevs', ['plemmatka_id' => $plemmatka->getId()]);
    }
}
