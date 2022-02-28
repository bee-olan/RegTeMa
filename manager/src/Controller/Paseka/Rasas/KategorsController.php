<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Rasas;

use App\Model\Paseka\Entity\Rasas\Kategor\Permission;
use App\Model\Paseka\Entity\Rasas\Kategor\Kategor;
use App\Model\Paseka\UseCase\Rasas\Kategor\Copy;
use App\Model\Paseka\UseCase\Rasas\Kategor\Create;
use App\Model\Paseka\UseCase\Rasas\Kategor\Edit;
use App\Model\Paseka\UseCase\Rasas\Kategor\Remove;
use App\ReadModel\Paseka\Rasas\KategorFetcher;
use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/rasas/kategors", name="paseka.rasas.kategors")
 * @IsGranted("ROLE_WORK_MANAGE_PROJECTS")
 */
class KategorsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param KategorFetcher $fetcher
     * @return Response
     */
    public function index(KategorFetcher $fetcher): Response
    {
        $kategors = $fetcher->all();
        $permissions = Permission::names();

        return $this->render('app/paseka/rasas/kategors/index.html.twig', compact('kategors', 'permissions'));
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
                return $this->redirectToRoute('paseka.rasas.kategors');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/rasas/kategors/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Kategor $kategor
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Kategor $kategor, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromRole($kategor);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.rasas.kategors.show', ['id' => $kategor->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/rasas/kategors/edit.html.twig', [
            'kategor' => $kategor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/copy", name=".copy")
     * @param Kategor $kategor
     * @param Request $request
     * @param Copy\Handler $handler
     * @return Response
     */
    public function copy(Kategor $kategor, Request $request, Copy\Handler $handler): Response
    {
        $command = new Copy\Command($kategor->getId()->getValue());

        $form = $this->createForm(Copy\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.rasas.kategors');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/rasas/kategors/copy.html.twig', [
            'kategor' => $kategor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Kategor $kategor
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Kategor $kategor, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.rasas.kategors.show', ['id' => $kategor->getId()]);
        }

        $command = new Remove\Command($kategor->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.rasas.kategors');
    }

    /**
     * @Route("/{id}", name=".show")
     * @param Kategor $kategor
     * @return Response
     */
    public function show(Kategor $kategor): Response
    {
        return $this->render('app/paseka/rasas/kategors/show.html.twig', compact('kategor'));
    }
}
