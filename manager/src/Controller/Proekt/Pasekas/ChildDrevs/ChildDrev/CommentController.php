<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\ChildDrevs\ChildDrev;

use App\Controller\ErrorHandler;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrev;
use App\Model\Comment\Entity\Comment\Comment;
use App\Model\Comment\UseCase\Comment\Edit;
use App\Model\Comment\UseCase\Comment\Remove;
use App\Security\Voter\Comment\CommentAccess;
use App\Security\Voter\Adminka\Matkas\ChildMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/proekt/pasekas/childmatkas/{childmatka_id}/comment", name="proekt.pasekas.childmatkas.comment")
 * @ParamConverter("childmatka", options={"id" = "childmatka_id"})
 */
class CommentController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param ChildDrev $childmatka
     * @param Comment $comment
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(ChildDrev $childmatka, Comment $comment, Request $request, Edit\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(ChildDrevAccess::MANAGE, $childmatka);
        $this->checkCommentIsForChildDrev($childmatka, $comment);
//        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = Edit\Command::fromComment($comment);

        $form = $this->createForm(Edit\Form::class, $command);
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

        return $this->render('/proekt/pasekas/childmatkas/comment/edit.html.twig', [
            'plemmatka' => $childmatka->getPlemMatka(),
            'childmatka' => $childmatka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param ChildDrev $childmatka
     * @param Comment $comment
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(ChildDrev $childmatka, Comment $comment, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete-comment', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

//        $this->denyAccessUnlessGranted(ChildDrevAccess::VIEW, $childmatka);
        $this->checkCommentIsForChildDrev($childmatka, $comment);
        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = new Remove\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('proekt.pasekas.childmatkas.show', [
            'id' => $childmatka->getId()
        ]);
    }

    private function checkCommentIsForChildDrev(ChildDrev $childmatka, Comment $comment): void
    {
        if (!(
            $comment->getEntity()->getType() === ChildDrev::class &&
            (int)$comment->getEntity()->getId() === $childmatka->getId()->getValue()
        )) {
            throw $this->createNotFoundException();
        }
    }
}
