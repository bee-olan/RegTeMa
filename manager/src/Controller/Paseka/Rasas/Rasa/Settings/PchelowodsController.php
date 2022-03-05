<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Rasas\Rasa\Settings;

use App\Annotation\Guid;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Id;
use App\Model\Paseka\Entity\Rasas\Rasa\Rasa;
use App\Model\Paseka\UseCase\Rasas\Rasa\Pcheloship;
use App\Security\Voter\Paseka\Rasas\RasaAccess;
use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/rasas/{rasa_id}/settings/pchelowods", name="paseka.rasas.rasa.settings.pchelowods")
 * @ParamConverter("rasa", options={"id" = "rasa_id"})
 */
class PchelowodsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param Rasa $rasa
     * @return Response
     */
    public function index(Rasa $rasa): Response
    {
        // $this->denyAccessUnlessGranted(RasaAccess::MANAGE_MEMBERS, $rasa);

        return $this->render('app/paseka/rasas/rasa/settings/pchelowods/index.html.twig', [
            'rasa' => $rasa,
            'pcheloships' => $rasa->getPcheloships(),
        ]);
    }

    /**
     * @Route("/assign", name=".assign")
     * @param Rasa $rasa
     * @param Request $request
     * @param Pcheloship\Add\Handler $handler
     * @return Response
     */
    public function assign(Rasa $rasa, Request $request, Pcheloship\Add\Handler $handler): Response
    {
        // $this->denyAccessUnlessGranted(RasaAccess::MANAGE_MEMBERS, $rasa);

        if (!$rasa->getLinias()) {
            $this->addFlash('error', 'Add departments before adding pchelowods.');
            return $this->redirectToRoute('paseka.rasas.rasa.settings.pchelowods', ['rasa_id' => $rasa->getId()]);
        }

        $command = new Pcheloship\Add\Command($rasa->getId()->getValue());

        $form = $this->createForm(Pcheloship\Add\Form::class, $command, ['rasa' => $rasa->getId()->getValue()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.rasas.rasa.settings.pchelowods', ['rasa_id' => $rasa->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/rasas/rasa/settings/pchelowods/assign.html.twig', [
            'rasa' => $rasa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{pchelowod_id}/edit", name=".edit")
     * @param Rasa $rasa
     * @param string $pchelowod_id
     * @param Request $request
     * @param Pcheloship\Edit\Handler $handler
     * @return Response
     */
    public function edit(Rasa $rasa, string $pchelowod_id, Request $request, Pcheloship\Edit\Handler $handler): Response
    {
        // $this->denyAccessUnlessGranted(RasaAccess::MANAGE_MEMBERS, $rasa);

        $pcheloship = $rasa->getPcheloship(new Id($pchelowod_id));

        $command = Pcheloship\Edit\Command::fromMembership($rasa, $pcheloship);

        $form = $this->createForm(Pcheloship\Edit\Form::class, $command, ['rasa' => $rasa->getId()->getValue()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.rasas.rasa.settings.pchelowods', ['rasa_id' => $rasa->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/rasas/rasa/settings/pchelowods/edit.html.twig', [
            'rasa' => $rasa,
            'pcheloship' => $pcheloship,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{pchelowod_id}/revoke", name=".revoke", methods={"POST"})
     * @param Rasa $rasa
     * @param string $pchelowod_id
     * @param Request $request
     * @param Pcheloship\Remove\Handler $handler
     * @return Response
     */
    public function revoke(Rasa $rasa, string $pchelowod_id, Request $request, Pcheloship\Remove\Handler $handler): Response
    {
        // $this->denyAccessUnlessGranted(RasaAccess::MANAGE_MEMBERS, $rasa);

        if (!$this->isCsrfTokenValid('revoke', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.rasas.rasa.settings.departments', ['rasa_id' => $rasa->getId()]);
        }

        $command = new Pcheloship\Remove\Command($rasa->getId()->getValue(), $pchelowod_id);

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.rasas.rasa.settings.pchelowods', ['rasa_id' => $rasa->getId()]);
    }

    /**
     * @Route("/{pchelowod_id}", name=".show", requirements={"pchelowod_id"=Guid::PATTERN}))
     * @param Rasa $rasa
     * @return Response
     */
    public function show(Rasa $rasa): Response
    {
        return $this->redirectToRoute('paseka.rasas.rasa.settings.pchelowods', ['rasa_id' => $rasa->getId()]);
    }
}
