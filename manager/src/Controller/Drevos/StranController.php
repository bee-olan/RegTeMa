<?php

declare(strict_types=1);

namespace App\Controller\Drevos;


use App\Model\Drevos\Entity\Strans\Stran;
use App\Model\Drevos\UseCase\Strans\Create;
use App\Model\Drevos\UseCase\Strans\Edit;
use App\Model\Drevos\UseCase\Strans\Remove;

use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\StranFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// * @IsGranted("ROLE_Paseka_MANAGE_MATERIS")
/**
 * @Route("/drevos/stranas", name="drevos.strans")
 */
class StranController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param StranFetcher $fetcher
     * @return Response
     */
    public function index(StranFetcher $fetcher): Response
    {
        $stranas = $fetcher->all();

        return $this->render('app/drevos/strans/index.html.twig', compact('stranas'));
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
                return $this->redirectToRoute('drevos.strans');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/strans/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Stran $strana
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Stran $strana, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromStran($strana);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.strans.show', ['id' => $strana->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/strans/edit.html.twig', [
            'strana' => $strana,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Stran $strana
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Stran $strana, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('drevos.strans.show', ['id' => $strana->getId()]);
        }

        $command = new Remove\Command($strana->getId()->getValue());

        try {
            $handler->handle($command);
            return $this->redirectToRoute('drevos.strans');
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drevos.strans.show', ['id' => $strana->getId()]);
    }

    /**
     * @Route("/{id}", name=".show")
     * @return Response
     */
    public function show(): Response
    {
        return $this->redirectToRoute('drevos.strans');
    }
}
