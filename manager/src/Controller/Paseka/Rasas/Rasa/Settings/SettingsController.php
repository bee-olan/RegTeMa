<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Rasas\Rasa\Settings;

use App\Annotation\Guid;
use App\Model\Paseka\Entity\Rasas\Rasa\Rasa;
// use App\Model\Paseka\UseCase\Projects\Project\Archive;
use App\Model\Paseka\UseCase\Rasas\Rasa\Edit;
// use App\Model\Paseka\UseCase\Projects\Project\Reinstate;
use App\Model\Paseka\UseCase\Rasas\Rasa\Remove;
// use App\Security\Voter\Work\ProjectAccess;
use App\Controller\ErrorHandler;
// use App\Model\Paseka\Entity\Rasas\Rasa\Rasa;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/rasas/{rasa_id}/rasa/settings", name="paseka.rasas.rasa.settings")
 * @ParamConverter("rasa", options={"id" = "rasa_id"})
 */
class SettingsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="", requirements={"id"=Guid::PATTERN})
     * @param Rasa $rasa
     * @return Response
     */
    public function show(Rasa $rasa): Response
    {
        // $this->denyAccessUnlessGranted(ProjectAccess::EDIT, $project);

        return $this->render('app/paseka/rasas/rasa/settings/show.html.twig', compact('rasa'));
    }

    /**
     * @Route("/edit", name=".edit")
     * @param Rasa $rasa
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Rasa $rasa, Request $request, Edit\Handler $handler): Response
    {
        // $this->denyAccessUnlessGranted(rasaAccess::EDIT, $rasa);

        $command = Edit\Command::fromRasa($rasa);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.rasas.rasa.show', ['id' => $rasa->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/rasas/rasa/settings/edit.html.twig', [
            'rasa' => $rasa,
            'form' => $form->createView(),
        ]);
    }

    // /**
    //  * @Route("/archive", name=".archive", methods={"POST"})
    //  * @param Rasa $rasa
    //  * @param Request $request
    //  * @param Archive\Handler $handler
    //  * @return Response
    //  */
    // // public function archive(Rasa $rasa, Request $request, Archive\Handler $handler): Response
    // // {
    // //     if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
    // //         return $this->redirectToRoute('matkis.rasas.rasa.show', ['id' => $rasa->getId()]);
    // //     }

    // //     $this->denyAccessUnlessGranted(rasaAccess::EDIT, $rasa);

    // //     $command = new Archive\Command($rasa->getId()->getValue());

    // //     try {
    // //         $handler->handle($command);
    // //     } catch (\DomainException $e) {
    // //         $this->errors->handle($e);
    // //         $this->addFlash('error', $e->getMessage());
    // //     }

    // //     return $this->redirectToRoute('matkis.rasas.rasa.settings', ['rasa_id' => $rasa->getId()]);
    // // }

    // // /**
    // //  * @Route("/reinstate", name=".reinstate", methods={"POST"})
    // //  * @param Rasa $rasa
    // //  * @param Request $request
    // //  * @param Reinstate\Handler $handler
    // //  * @return Response
    // //  */
    // // public function reinstate(Rasa $rasa, Request $request, Reinstate\Handler $handler): Response
    // // {
    // //     if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
    // //         return $this->redirectToRoute('matkis.rasas.rasa.settings', ['rasa_id' => $rasa->getId()]);
    // //     }

    // //     $this->denyAccessUnlessGranted(rasaAccess::EDIT, $rasa);

    // //     $command = new Reinstate\Command($rasa->getId()->getValue());

    // //     try {
    // //         $handler->handle($command);
    // //     } catch (\DomainException $e) {
    // //         $this->errors->handle($e);
    // //         $this->addFlash('error', $e->getMessage());
    // //     }

    // //     return $this->redirectToRoute('matkis.rasas.rasa.settings', ['rasa_id' => $rasa->getId()]);
    // // }

    /**
     * @Route("/delete", name=".delete", methods={"POST"})
     * @param Rasa $rasa
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Rasa $rasa, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.rasas.rasa.settings', ['rasa_id' => $rasa->getId()]);
        }

        // $this->denyAccessUnlessGranted(rasaAccess::EDIT, $rasa);

        $command = new Remove\Command($rasa->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.rasas');
    }
}
