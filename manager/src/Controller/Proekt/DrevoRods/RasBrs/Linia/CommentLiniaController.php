<?php

declare(strict_types=1);

namespace App\Controller\Proekt\DrevoRods\RasBrs\Linia;

use App\Controller\ErrorHandler;

use App\Model\Comment\Entity\Comment\Comment;
use App\Model\Comment\UseCase\Comment\Edit;
use App\Model\Comment\UseCase\Comment\Remove;


use App\Model\Drevos\Entity\Rass\Ras;
use App\Security\Voter\Comment\CommentAccess;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/rasas/linias/{rasa_id}/comment", name="app.proekts.pasekas.rasas.linias.comment")
 * @ParamConverter("rasa", options={"id" = "rasa_id"})
 */
class CommentLiniaController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Ras $rasa
     * @param Comment $comment
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request, Comment $comment, Ras $rasa, Edit\Handler $handler): Response
    {
//       dd($rasa->getLinias());
//        dd($linia->getRas()->getName());
//        $this->denyAccessUnlessGranted(LiniaAccess::VIEW, $linia);
        $this->checkCommentIsForLinia($rasa, $comment);
        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = Edit\Command::fromComment($comment);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.pasekas.rasas.linias.plemmatka', ['id' => $rasa->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/pasekas/rasas/linias/comment/edit.html.twig', [
            'rasa' => $rasa,
            'linia' => $rasa->getLinias(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Ras $rasa
     * @param Comment $comment
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Ras $rasa, Comment $comment, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete-comment', $request->request->get('token'))) {
            return $this->redirectToRoute('app.proekts.pasekas.rasas.linias.plemmatka', ['id' => $rasa->getId()]);
        }

//        $this->denyAccessUnlessGranted(LiniaAccess::VIEW, $linia);
        $this->checkCommentIsForLinia($rasa, $comment);
        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = new Remove\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app.proekts.pasekas.rasas.linias.plemmatka', ['id' => $rasa->getId()]);
    }

    private function checkCommentIsForLinia(Ras $rasa, Comment $comment): void
    {
        if (!(
            $comment->getEntity()->getType() === Ras::class &&
            $comment->getEntity()->getId() === $rasa->getId()->getValue()
        )) {
            throw $this->createNotFoundException();
        }
    }
}
